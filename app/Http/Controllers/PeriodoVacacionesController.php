<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use App\Models\PeriodoVacaciones;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PeriodoVacacionesController extends Controller
{
    public function index()
    {
        $periodos = PeriodoVacaciones::where('FICHA', auth()->user()->fichaActiva())->orderBy('FECHA', 'ASC')->paginate(15);
        $configuracion = DB::table('configuraciones')->first();
        return view('periodo_vacaciones.index')->with(['periodos' => $periodos, 'configuracion' => $configuracion]);
    }

    public function calcular()
    {
        $ficha = Ficha::find(auth()->user()->fichaActiva());
        $periodos = $this->obtenerPeriodosConFechas($ficha->FECHA_INICIO);

        foreach ($periodos as $key => $periodo) {

            $fecha = $periodo['fecha'];
            $fecha_baja = date('Y-m-d', strtotime($ficha->FECHA_BAJA));

            $data = DB::select("
                SELECT
                    TOP 1
                    CONVERT(VARCHAR(10), DATEADD(YEAR,+1,'$fecha')-1 , 103) Fecha_fin_per,
                    DATEDIFF(DAY , '$fecha',GETDATE())+1 Dias_per,
                    CONVERT(VARCHAR(10),GETDATE(), 103) Fecha_dia,
                    ROUND(((CAST(15 AS decimal ) * CAST(DATEDIFF(DAY , '$fecha', GETDATE())+1 AS DECIMAL) )/365),0) Dias_pe_total,
                    ROUND(((CAST(15 AS decimal ) * CAST(DATEDIFF(DAY , '$fecha' , '$fecha_baja')+1 AS DECIMAL) )/365),0) Dias_pe_total_BAJA
            ");

            $fechaDia = Carbon::createFromFormat('d/m/Y', $data[0]->Fecha_dia)->format('Y-m-d');
            $fechaFinPer = Carbon::createFromFormat('d/m/Y', $data[0]->Fecha_fin_per)->format('Y-m-d');
            $valorDiaGozar = 0;
            if ((strtotime($fechaDia) >= strtotime($fecha)) and (strtotime($fechaDia) <= strtotime($fechaFinPer))) {
                $valorDiaGozar = $ficha->ESTATUS = 'A' ? $data[0]->Dias_pe_total : $data[0]->Dias_pe_total_BAJA;
            } else {
                if (strtotime($fechaDia) >= strtotime($fechaFinPer)) {
                    $valorDiaGozar = 15;
                }

                if (strtotime($fechaDia) <= strtotime($fechaFinPer)) {
                    $valorDiaGozar = 0;
                }
            }

            PeriodoVacaciones::updateOrCreate(
                [
                    'PERIODO' => $periodo['rango'],
                    'FICHA' => $ficha->NUMERO,
                ],
                [
                    'FECHA' => $fecha,
                    'ANIOS' => $key + 1,
                    'DIA_GOZAR' => $valorDiaGozar,
                    'FECHA_FIN' => $fechaFinPer
                ]
            );
        }

        return redirect()->route('periodo_vacaciones.index')->with(['status' => 'success', 'message' => 'Periodo de vacaciones actualizada correctamente!']);
    }



    private function obtenerPeriodosConFechas($fechaInicio) {
        $fechaBase = Carbon::parse($fechaInicio);
        $diaMes = $fechaBase->format('d-m');
        $anioInicial = $fechaBase->year;

        $anioActual = Carbon::now()->year;
        $periodos = [];

        for ($i = $anioInicial; $i <= $anioActual; $i++) {
            $rango = "$i-" . ($i + 1);
            $fechaGenerada = Carbon::createFromFormat('Y-d-m', "$i-$diaMes")->format('Y-m-d');

            $periodos[] = [
                'rango' => $rango,
                'fecha' => $fechaGenerada,
            ];
        }

        return $periodos;
    }
}
