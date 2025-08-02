<?php

namespace App\Http\Controllers;

use App\Models\BitacoraRequisicion;
use App\Models\RequisicionH;
use Illuminate\Http\Request;

class BitacoraRequisicionController extends Controller
{
    public function index(RequisicionH $requisicion)
    {
        $bitacora = BitacoraRequisicion::selectRaw("*, FORMAT(fecha, 'dd/MM/yyyy HH:mm') as fecha2")
                                ->where('requisicion_h', $requisicion->NUMERO)
                                ->with('usuario')
                                ->orderBy('fecha', 'desc')
                                ->get();  
                                
        return response()->json($bitacora);
    }
}
