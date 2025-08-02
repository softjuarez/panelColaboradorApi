<?php

namespace App\Http\Controllers;

use App\Models\RequisicionH;
use App\Models\RequisicionP;
use Illuminate\Http\Request;

class RequisicionPController extends Controller
{
    public function store(Request $request, RequisicionH $requisicion) 
    {
        $request->validate([
            'concepto' => ['required'],
            'valor' => ['required', 'numeric', 'min:1'],
        ]);
        
        $detalle = new RequisicionP();
        $detalle->REQ_H = $requisicion->NUMERO;
        $detalle->FECHA = date('Y-m-d');
        $detalle->CONCPPTO = $request->concepto;
        $detalle->VALOR = $request->valor;
        $detalle->save();

        $detalles = RequisicionP::where('REQ_H', $requisicion->NUMERO)->selectRaw("RECNUM, FORMAT(FECHA, 'dd-MM-yyyy') FECHA, (SELECT DESCRIPCION FROM CONCPPTO WHERE NUMERO_INTERNO = REQ_P.CONCPPTO) CONCPPTO2, VALOR")->get();

        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $detalles, 'errors' => []], 200);
    }

    public function edit(RequisicionP $detalle)
    {
        return response()->json(['estatus' => true, 'message' => '', 'detalle' => $detalle, 'errors' => []], 200);
    }

    public function update(Request $request, RequisicionP $detalle)
    {
        $request->validate([
            'concepto' => ['required'],
            'valor' => ['required', 'numeric', 'min:1'],
        ]);

        $detalle->CONCPPTO = $request->concepto;
        $detalle->VALOR = $request->valor;
        $detalle->save();

        $detalles = RequisicionP::where('REQ_H', $detalle->REQ_H)->selectRaw("RECNUM, FORMAT(FECHA, 'dd-MM-yyyy') FECHA, (SELECT DESCRIPCION FROM CONCPPTO WHERE NUMERO_INTERNO = REQ_P.CONCPPTO) CONCPPTO2, VALOR")->get();
        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $detalles, 'errors' => []], 200);
    }

    public function delete(RequisicionP $detalle)
    {
        $detalle->delete();

        $detalles = RequisicionP::where('REQ_H', $detalle->REQ_H)->selectRaw("RECNUM, FORMAT(FECHA, 'dd-MM-yyyy') FECHA, (SELECT DESCRIPCION FROM CONCPPTO WHERE NUMERO_INTERNO = REQ_P.CONCPPTO) CONCPPTO2, VALOR")->get();
        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $detalles, 'errors' => []], 200);
    }
}
