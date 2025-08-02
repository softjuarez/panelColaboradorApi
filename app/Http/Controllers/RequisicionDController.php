<?php

namespace App\Http\Controllers;

use App\Models\RequisicionD;
use App\Models\RequisicionH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RequisicionDController extends Controller
{
    public function index(RequisicionH $requisicion)
    {
        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $requisicion->detalles, 'errors' => []], 200);
    }

    public function store(Request $request, RequisicionH $requisicion)
    {
        $request->validate([
            'unidad_medida' => ['required'],
            'cantidad' => ['required', 'numeric', 'gt:0'],
            'precio_unitario' => ['required', 'numeric', 'gt:0'],
            'descripcion' => ['required', 'string', 'max:150'],
        ]);

        $numero = DB::connection('sqlsrv-secondary')->table('NPROXPV')->select(DB::raw("(REQ_D + 1) siguiente"))->first();
        DB::connection('sqlsrv-secondary')->table('NPROXPV')->increment('REQ_D');


        $maxRenglon = RequisicionD::where('REQ_H', $requisicion->NUMERO)->max('RENGLON');
        $nuevoRenglon = $maxRenglon ? $maxRenglon + 1 : 1;

        $detalle = new RequisicionD();
        $detalle->REQ_H = $requisicion->NUMERO;
        $detalle->RENGLON = $nuevoRenglon;
        $detalle->FECHA = $requisicion->FECHA;
        $detalle->ESTATUS = $requisicion->ESTATUS;
        $detalle->RECURSO = 999;
        $detalle->CANT_REQ = $request->cantidad;
        $detalle->CANT_ORIGINAL = $request->cantidad;
        $detalle->CANTIDAD = $request->cantidad;
        $detalle->CANT_OC = $request->cantidad;
        $detalle->CANT_AUT1 = $request->cantidad;
        $detalle->CANT_AUT2 = $request->cantidad;
        $detalle->CANT_AUT3 = $request->cantidad;
        $detalle->CANT_AUT4 = $request->cantidad;
        $detalle->DESCRIPCION = $request->descripcion;
        $detalle->LOTE = 'UNICO';
        $detalle->NUMERO = $numero->siguiente;
        $detalle->PU = $request->precio_unitario;
        $detalle->UNI_MED = $request->unidad_medida;
        $detalle->CANCELADA = 'N';
        $detalle->AUT_SN = 'N';
        $detalle->AUT_SN2 = 'N';
        $detalle->AUT_SN3 = 'N';
        $detalle->INVITAR_S_N = 'N';
        $detalle->SOLICITANTE_NUM = auth()->user()->fichaActiva();
        $detalle->save();

        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $requisicion->detalles, 'errors' => []], 200);
    }

    public function edit(RequisicionD $detalle)
    {
        return response()->json(['estatus' => true, 'message' => '', 'detalle' => $detalle, 'errors' => []], 200);
    }

    public function update(Request $request, RequisicionD $detalle)
    {
        $request->validate([
            'unidad_medida' => ['required'],
            'cantidad' => ['required', 'numeric', 'gt:0'],
            'precio_unitario' => ['required', 'numeric', 'gt:0'],
            'descripcion' => ['required', 'string', 'max:150'],
        ]);

        $detalle->CANT_REQ = $request->cantidad;
        $detalle->CANT_ORIGINAL = $request->cantidad;
        $detalle->CANTIDAD = $request->cantidad;
        $detalle->CANT_OC = $request->cantidad;
        $detalle->CANT_AUT1 = $request->cantidad;
        $detalle->CANT_AUT2 = $request->cantidad;
        $detalle->CANT_AUT3 = $request->cantidad;
        $detalle->CANT_AUT4 = $request->cantidad;
        $detalle->DESCRIPCION = $request->descripcion;
        $detalle->UNI_MED = $request->unidad_medida;
        $detalle->PU = $request->precio_unitario;
        $detalle->save();


        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $detalle->requisicion->detalles, 'errors' => []], 200);
    }

    public function delete(RequisicionD $detalle)
    {
        $detalle->delete();
        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $detalle->requisicion->detalles, 'errors' => []], 200);
    }
}
