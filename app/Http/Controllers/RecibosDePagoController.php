<?php

namespace App\Http\Controllers;

use App\Events\ReciboGenerado;
use App\Models\Bitacora;
use App\Models\Ficha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class RecibosDePagoController extends Controller
{
    public function launcher()
    {
        return view('lanzadores.recibos_de_pago');
    }

    public function generar($fecha_inicio, $fecha_fin)
    {
        $recibos = Ficha::join('NOMINA_D', 'FICHA.NUMERO', '=', 'NOMINA_D.FICHA')
            ->join('NOMINA_H', 'NOMINA_D.NOMINA_H', '=', 'NOMINA_H.NUMERO_INTERNO')
            ->whereBetween(DB::raw("FORMAT(NOMINA_H.FECHA_PAGO, 'yyyy-MM-dd')"), [$fecha_inicio, $fecha_fin])
            ->where(DB::raw("rtrim(NOMINA_H.BONO_AGUINALDO)"), '=', '')
            ->where('FICHA.NUMERO', '=', auth()->user()->fichaActiva())

            ->selectRaw("FICHA.numero_dpi, FICHA.NIT, FICHA.NOMBRE, FICHA.PUESTO_INGRESA, NOMINA_H.FECHA_PAGO, NOMINA_H.FECHA_INICIO, NOMINA_H.FECHA_FIN, (
                            CASE
                            WHEN RTRIM(NOMINA_D.FORMA_PAGO) = 'TR' THEN 'TRANSFERENCIA'
                            WHEN RTRIM(NOMINA_D.FORMA_PAGO) = 'CH' THEN 'CHEQUE'
                            ELSE 'OTRO'
                            END
                        ) AS FORMA_PAGO, NOMINA_D.DIAS_TRABAJADOS, NOMINA_D.VLR_DIAS_TRAB, NOMINA_D.BONIFICAC_BASE,
                            NOMINA_D.NUMERO, NOMINA_D.NUMERO NOMINA_D_NUMERO, NOMINA_D.IGSS, NOMINA_D.NO_CHEQUE_LOTE, FICHA.CORREO, NOMINA_D.NO_CHEQUE_LOTE")
            ->orderBy('NOMINA_H.FECHA_INICIO', 'desc')

            ->get();

        view()->share(['recibos' => $recibos, 'parametros' => ['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin]]);

        $pdf = PDF::loadView('reportes.recibos_de_pago')->setPaper('a4', 'portrait');

        if (auth()->user()->fichaActiva() != 0) {
            Bitacora::create([
                'ficha_id' => auth()->user()->fichaActiva(),
                'user_id' => auth()->id(),
                'descripcion' => "Usuario " . auth()->user()->name . " genero los recibos de pago del " . date('d/m/Y', strtotime($fecha_inicio)) . ' al ' . date('d/m/Y', strtotime($fecha_fin)),
                'accion' => 'Generar Reporte',
                'modulo' => 'Recibos de Pago',
                'ip' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);
        }

        return $pdf->stream('recibos.pdf');
    }


}
