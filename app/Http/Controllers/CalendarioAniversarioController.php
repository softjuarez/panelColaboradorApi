<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarioAniversarioController extends Controller
{
    public function index()
    {
        return view('aniversarios.index');
    }

    public function obtenerAniversarios()
    {
        $empleados = Ficha::select('NOMBRE', 'FECHA_INICIO')->whereIn('ESTATUS', ['A', 'S'])->get();
        $eventos = [];

        foreach ($empleados as $empleado) {
            if (!$empleado->FECHA_INICIO) continue;

            $fechaOriginal = Carbon::parse($empleado->FECHA_INICIO);
            $aniversarioEsteAno = Carbon::createFromDate(now()->year, $fechaOriginal->month, $fechaOriginal->day);

            $mes = $aniversarioEsteAno->format('m');

            if ($mes == date('m') || $mes == date('m', strtotime('+1 month'))) {
                $eventos[] = [
                    'title' => '🎊 ' . $empleado->NOMBRE,
                    'start' => $aniversarioEsteAno->toDateString(),
                    'allDay' => true,
                ];
            }
        }

        return response()->json($eventos);
    }
}
