<?php

namespace App\Http\Controllers;

use App\Models\RequisicionD;
use App\Models\RequisicionH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AutorizaPPTORequisicionDController extends Controller
{
    public function edit(RequisicionD $detalle)
    {
        return response()->json(['estatus' => true, 'message' => '', 'detalle' => $detalle, 'errors' => []], 200);
    }

    public function update(Request $request, RequisicionD $detalle)
    {
        $request->validate([
            'unidad_medida' => ['required'],
            'cantidad' => ['required', 'numeric', 'min:1'],
            'precio_unitario' => ['required', 'numeric'],
            'centro_costo' => ['nullable'],
            'descripcion' => ['required', 'string', 'max:150'],
        ]);

        $detalle->CANT_ORIGINAL = $request->cantidad;
        $detalle->CANTIDAD = $request->cantidad; 
        $detalle->CANT_OC = $request->cantidad;  
        $detalle->CANT_AUT1 = $request->cantidad;
        $detalle->CANT_AUT2 = $request->cantidad;
        $detalle->CANT_AUT3 = $request->cantidad;
        $detalle->CANT_AUT4 = $request->cantidad;
        $detalle->save();

        
        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $detalle->requisicion->detalles, 'errors' => []], 200);
    }
}
