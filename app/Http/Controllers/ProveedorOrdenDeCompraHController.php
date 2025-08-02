<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\OrdenDeCompraH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorOrdenDeCompraHController extends Controller
{
    public function index()
    {
        $ordenes = OrdenDeCompraH::where('ESTATUS', 'B')
                    ->whereIn('PRVEEDOR', auth()->user()->proveedores->pluck('NUMERO'))
                    ->whereRaw('VLR_FOB > (
                        SELECT ISNULL(SUM(valor_gran_total), 0)
                        FROM '. Documento::getTableName() . '
                        WHERE ordcom_h = ORDCOM_H.numero
                        AND estatus NOT IN (1,4)
                    )')
                    ->orderBy('NUMERO', 'DESC')
                    ->paginate(15);

        return view('proveedor_ordenes_compra.index')->with(['ordenes' => $ordenes]);
    }

    public function edit(OrdenDeCompraH $orden)
    {
        $monedas = DB::connection('sqlsrv-secondary')->table('MONEDA')->selectRaw('rtrim(CLAVE) CLAVE, rtrim(NOMBRE_CORTO) NOMBRE_CORTO')->get();
        $proveedores = DB::connection('sqlsrv-secondary')->table('PRVEEDOR')->get();

        return view('proveedor_ordenes_compra.edit')->with(['orden' => $orden, 'proveedores' => $proveedores, 'monedas' => $monedas]);
    }
}
