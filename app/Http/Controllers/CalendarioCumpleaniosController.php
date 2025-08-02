<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use Illuminate\Http\Request;

class CalendarioCumpleaniosController extends Controller
{
    public function index()
    {
        return view('cumpleanios.index');
    }

    public function obtenerCumpleanios()
    {
        $empleados = Ficha::select('NOMBRE', 'FECHA_NACIM')
            ->whereIn('ESTATUS', ['A', 'S'])
            ->get();

        $eventos = [];

        foreach ($empleados as $empleado) {
            $fecha = date('Y') . '-' . date('m-d', strtotime($empleado->FECHA_NACIM));
            $mes = date('m', strtotime($fecha));

            // Solo mostrar los cumpleaños del mes actual y el siguiente
            if ($mes == date('m') || $mes == date('m', strtotime('+1 month'))) {
                $eventos[] = [
                    'title' => $empleado->NOMBRE,
                    'start' => $fecha,
                    'allDay' => true,
                ];
            }
        }

        return response()->json($eventos);
    }
}
