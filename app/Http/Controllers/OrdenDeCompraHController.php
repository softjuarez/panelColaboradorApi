<?php

namespace App\Http\Controllers;

use App\Models\OrdenDeCompraD;
use App\Models\OrdenDeCompraH;
use App\Models\RequisicionD;
use App\Models\RequisicionH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class OrdenDeCompraHController extends Controller
{
    public function index($search = '')
    {
        $query = OrdenDeCompraH::query()->orderBy('ORDCOM_H.NUMERO', 'DESC');

        if ($search) {
            $query->join(DB::raw('PRVEEDOR'), function($join) {
                    $join->on('ORDCOM_H.PRVEEDOR', '=', 'PRVEEDOR.NUMERO');
                })
                ->where('PRVEEDOR.NOMBRE_COMPLETO', 'like', '%' . $search . '%');
        }

        return view('ordenes_compra.index')->with(['ordenes' => $query->paginate(15), 'search' => $search]);
    }

    public function create(RequisicionH $requisicion)
    {
        $defaults = DB::connection('sqlsrv-secondary')->table('DEFAULTS')->selectRaw('*, (1 + (Porc_iva/100.00)) porcentaje_iva')->first();

        $encabezados = DB::connection('sqlsrv-secondary')->select("
            SELECT DISTINCT
                    CAST(d.PRVEEDOR_AUT as INT) PRVEEDOR_AUT,
                    p.DIAS_CREDITO,
                    h.EMPRESA,
                    CAST(h.COMENTARIOS AS VARCHAR(MAX)) AS COMENTARIOS,
                    h.USUARIO,
                    h.FECHA_ENTREGA,
                    'RQ-' + CAST(h.NUMERO AS VARCHAR) referencia,
                    p.CONTACTO,
                    h.PROYECTO,
                    CAST(rtrim(c.DESCRIPCION) AS VARCHAR(MAX)) AS DESCRIPCION
            FROM
                REQ_D d
                JOIN REQ_H h ON d.REQ_H = h.NUMERO
                JOIN PRVEEDOR p ON d.PRVEEDOR_AUT = p.NUMERO
                JOIN CTROCSTO c ON RTRIM(h.PROYECTO) = c.CLAVE
            WHERE
                h.NUMERO = $requisicion->NUMERO
                AND d.CANT_OC > 0
            GROUP BY
                d.PRVEEDOR_AUT,
                h.EMPRESA,
                CAST(h.COMENTARIOS AS VARCHAR(MAX)),
                h.USUARIO,
                h.NUMERO,
                h.FECHA_ENTREGA,
                h.PROYECTO,
                p.CONTACTO,
                p.DIAS_CREDITO,
                CAST(rtrim(c.DESCRIPCION) AS VARCHAR(MAX));
        ");

        $listadoDeOrdes = [];

        foreach ($encabezados as $encabezado) {
            $numero = DB::connection('sqlsrv-secondary')->table('NPROXPV')->selectRaw('ORDCOM_H +1 AS siguiente')->first();
            DB::connection('sqlsrv-secondary')->table('NPROXPV')->increment('ORDCOM_H');

            array_push($listadoDeOrdes, $numero->siguiente);

            $orden = new OrdenDeCompraH();
            $orden->NUMERO = $numero->siguiente;
            $orden->FECHA = date('Y-m-d');
            $orden->ESTATUS = 'A';
            $orden->PRVEEDOR = $encabezado->PRVEEDOR_AUT;
            $orden->MONEDA = 'Q';
            $orden->IVA_S_N = 'S';
            $orden->DIAS_CREDITO = $encabezado->DIAS_CREDITO;
            $orden->EMPRESA = $encabezado->EMPRESA;
            $orden->COMENTARIOS = $encabezado->COMENTARIOS;
            $orden->CONTACTO = $encabezado->USUARIO;
            $orden->VLR_FOB = 0;
            $orden->VLR_IVA = 0;
            $orden->VLR_FLETE = 0;
            $orden->VLR_GASTOS = 0;
            $orden->COTP_H = 0;
            $orden->PESO_KG = 0;
            $orden->VOLUMEN_M3 = 0;
            $orden->IMPORTADO_S_N = 'N';
            $orden->FECHA_ENTREGA = $encabezado->FECHA_ENTREGA;
            $orden->INST_EMBARQUE = '';
            $orden->REFERENCIA = $encabezado->referencia;
            $orden->CONTACTO1 = $encabezado->CONTACTO;
            $orden->PROYECTO = $encabezado->PROYECTO;
            $orden->save();

            $detalles = RequisicionD::where('REQ_H', $requisicion->NUMERO)->where('PRVEEDOR_AUT', $encabezado->PRVEEDOR_AUT)->get();

            foreach ($detalles as $key => $detalle) {
                $numeroDetalle = DB::connection('sqlsrv-secondary')->table('NPROXPV')->selectRaw('ORDCOM_D +1 AS siguiente')->first();
                DB::connection('sqlsrv-secondary')->table('NPROXPV')->increment('ORDCOM_D');

                $ordenDetalle = new OrdenDeCompraD();
                $ordenDetalle->ORDCOM_H = $numero->siguiente;
                $ordenDetalle->PRVEEDOR = $encabezado->PRVEEDOR_AUT;
                $ordenDetalle->RENGLON = $key +1;
                $ordenDetalle->RECURSO = $detalle->RECURSO;
                $ordenDetalle->ESTATUS = 'B';
                $ordenDetalle->FECHA = date('Y-m-d');
                $ordenDetalle->PRECIO_UNITARIO = $detalle->PU;
                $ordenDetalle->CANT_OC = $detalle->CANT_OC;
                $ordenDetalle->CANT_REQ = $detalle->CANT_OC;
                $ordenDetalle->CANT_ENT = 0;
                $ordenDetalle->DESCRIPCION = $detalle->DESCRIPCION;
                $ordenDetalle->CANCELADA = 'N';
                $ordenDetalle->VLR_FOB = $detalle->PU * $detalle->CANT_OC;
                $ordenDetalle->NUMERO = $numeroDetalle->siguiente;
                $ordenDetalle->REQ_D = $detalle->NUMERO;
                $ordenDetalle->LOTE = $detalle->LOTE;
                $ordenDetalle->save();

                DB::connection('sqlsrv-secondary')->statement("
                    INSERT INTO APL_OC (
                        ORDCOM_D, RECURSO, REQ_D, CANTIDAD
                    )
                    SELECT
                        od.NUMERO,
                        od.RECURSO,
                        od.REQ_D,
                        od.CANT_OC
                    FROM
                        ORDCOM_D od
                        JOIN ORDCOM_H oh ON od.ORDCOM_H = oh.NUMERO
                    WHERE
                        od.NUMERO = $ordenDetalle->NUMERO;
                ");
            }

            DB::connection('sqlsrv-secondary')->statement("
                -- Actualizar los totales en ORDCOM_H directamente con subconsultas
                UPDATE ORDCOM_H
                SET VLR_FOB = ISNULL((
                    SELECT SUM(VLR_FOB)
                    FROM ORDCOM_D
                    WHERE ORDCOM_D.ORDCOM_H = ORDCOM_H.NUMERO
                ), 0.00)
                WHERE NUMERO = $numero->siguiente;

                -- Actualizar el IVA directamente
                UPDATE ORDCOM_H
                SET VLR_IVA = (VLR_FOB - (VLR_FOB / $defaults->porcentaje_iva))
                WHERE IVA_S_N = 'S'
                AND VLR_IVA = 0
                AND NUMERO = $numero->siguiente;

                -- Actualizar ORDCOM_H para establecer el número de renglones
                UPDATE ORDCOM_H
                SET RENGLONES = (
                    SELECT COUNT(*)
                    FROM ORDCOM_D
                    WHERE ORDCOM_D.ORDCOM_H = ORDCOM_H.NUMERO
                )
                WHERE NUMERO = $numero->siguiente;
            ");
        }

        $requisicion->COMENTARIO5 = 'Ordenes generadas: ' . implode(',', $listadoDeOrdes);
        $requisicion->ESTATUS = 'I';
        $requisicion->save();

        return redirect()->route('autoriza-comite.index')->with(['status' => 'success', 'message' => 'Orden de compra generada correctamente!']);
    }

    public function edit(OrdenDeCompraH $orden)
    {
        $monedas = DB::connection('sqlsrv-secondary')->table('MONEDA')->selectRaw('rtrim(CLAVE) CLAVE, rtrim(NOMBRE_CORTO) NOMBRE_CORTO')->get();
        $proveedores = DB::connection('sqlsrv-secondary')->table('PRVEEDOR')->get();

        return view('ordenes_compra.edit')->with(['orden' => $orden, 'proveedores' => $proveedores, 'monedas' => $monedas]);
    }

    public function update()
    {

    }

    public function procesar(OrdenDeCompraH $orden)
    {
        $orden->ESTATUS = 'B';
        $orden->save();

        return redirect()->route('ordenes_compra.edit', $orden)->with(['status' => 'success', 'message' => 'Orden de compra procesada correctamente!']);
    }

    public function reporte(OrdenDeCompraH $orden)
    {
        view()->share(['orden' => $orden]);

        $pdf = PDF::loadView('reportes.orden_de_compra')->setPaper('a4', 'portrait');
        return $pdf->stream('ordenes.pdf');
    }
}
