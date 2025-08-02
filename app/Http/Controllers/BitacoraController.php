<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Ficha;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function launcher()
    {
        $fichas = Ficha::all();
        return view('lanzadores.bitacora')->with(['fichas' => $fichas]);
    }


    public function generar($fecha_inicial, $fecha_final, $ficha)
    {
        $bitacora = Bitacora::where('ficha_id', $ficha)->whereRaw("format(created_at, 'yyyy-MM-dd') between '$fecha_inicial' and '$fecha_final'")->orderBy('created_at', 'desc')->paginate(15);
        return view('reportes.bitacora')->with(['bitacora' => $bitacora]);
    }
}
