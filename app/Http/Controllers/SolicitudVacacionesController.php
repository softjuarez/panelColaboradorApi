<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use App\Models\PeriodoVacaciones;
use App\Models\SolicitudVacaciones;
use App\Models\VacacionD;
use App\Models\VacacionH;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use PDF;

class SolicitudVacacionesController extends Controller
{
    public function index()
    {
        $solicitudes = VacacionH::where('ficha', auth()->user()->fichaActiva())->orderBy('created_at', 'DESC')->paginate(15);

        return view('solicitud_vacaciones.index')->with(['solicitudes' => $solicitudes]);
    }

    public function new()
    {
        $ficha = Ficha::find(auth()->user()->fichaActiva());
        return view('solicitud_vacaciones.new')->with(['ficha' => $ficha]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'dias_vacaciones' => json_decode($request->dias_vacaciones, true)
        ]);

        $request->validate([
            'dias_vacaciones' => 'required|array|min:1',
            'dias_vacaciones.*.fecha' => 'required|date|after:today',
            'dias_vacaciones.*.valor' => 'required|numeric|in:0.5,1',
            'formato' => ['required', 'file', 'max:2048'],
            'solicitud_para' => 'required',
            'detalle_solicitud' => 'required',
        ]);

        $fechasSolicitadas = collect($request->dias_vacaciones)->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item['fecha'])->format('Y-m-d');
        });

        foreach ($fechasSolicitadas as $fecha => $solicitudes) {

            $registrosExistente = DB::table('VACAC_D')
                ->whereDate('FECHA_INICIO', $fecha)
                ->where('FICHA', auth()->user()->fichaActiva())
                ->get();

            $sumaExistente = $registrosExistente->sum('TOTAL');
            $tieneRegistroCompleto = $registrosExistente->contains('TOTAL', 1);

            $sumaSolicitada = $solicitudes->sum('valor');

            if ($tieneRegistroCompleto || $sumaExistente > 0) {
                throw ValidationException::withMessages([
                    'dias_vacaciones' => "La fecha $fecha ya tiene un día registrado."
                ]);
            }

            $total = $sumaExistente + $sumaSolicitada;

            if ($total > 1) {
                throw ValidationException::withMessages([
                    'dias_vacaciones' => "La suma total para la fecha $fecha excede 1 día (total: $total)."
                ]);
            }

            if ($sumaExistente == 0.5 && $sumaSolicitada == 1) {
                throw ValidationException::withMessages([
                    'dias_vacaciones' => "No puedes solicitar 1 día completo para $fecha porque ya existe 0.5 días registrados."
                ]);
            }
        }

        $ficha = Ficha::find(auth()->user()->fichaActiva());
        $configuracion = DB::table('configuraciones')->first();


        $totalDias = collect($request->dias_vacaciones)->sum('valor');
        $diasDisponibles = $ficha->diasDeVacacionesDisponibles();

        if ($totalDias > $diasDisponibles) {
            return response()->json([
                'success' => false,
                'message' => "No tiene suficientes días disponibles. Disponibles: {$diasDisponibles}, Solicitados: {$totalDias}"
            ], 422);
        }

        $periodos = PeriodoVacaciones::where('FICHA', $ficha->NUMERO)
        ->orderBy('FECHA', 'ASC')
        ->get()
        ->filter(function($periodo) use ($configuracion) {
            if ($periodo->esPeriodoActual()){
                return (($periodo->DIA_GOZAR - $periodo->DIA_GOZADOS) - ($periodo->esAplicableResguardoSemanaSanta() ? $configuracion->dias_resguardo_semana_santa : 0) - ($periodo->esAplicableResguardoFinDeAnio() ? $configuracion->dias_resguardo_fin_anio : 0)) > 0;
            } else {
                return ($periodo->DIA_GOZAR - $periodo->DIA_GOZADOS) > 0;
            }
        });

        $fechasSolicitadas = collect($request->dias_vacaciones)
        ->map(function ($item) {
            return [
                'fecha' => Carbon::parse($item['fecha']),
                'valor' => $item['valor']
            ];
        })
        ->sortBy('fecha');

        $fechasPorAsignar = $fechasSolicitadas;
        $solicitudesCreadas = [];


        foreach ($periodos as $periodo) {
            if ($fechasPorAsignar->isEmpty()) break;

            $diasDisponiblesPeriodo = $periodo->DIA_GOZAR - $periodo->DIA_GOZADOS;

            if ($periodo->esPeriodoActual()) {
                if ($periodo->esAplicableResguardoSemanaSanta()) {
                $diasDisponiblesPeriodo = $diasDisponiblesPeriodo - $configuracion->dias_resguardo_semana_santa;
                }

                if ($periodo->esAplicableResguardoFinDeAnio()) {
                    $diasDisponiblesPeriodo = $diasDisponiblesPeriodo - $configuracion->dias_resguardo_fin_anio;
                }
            }

            if ($diasDisponiblesPeriodo <= 0) continue;

            $diasAUsar = 0;
            $fechasParaEstePeriodo = collect();
            $fechasTemporales = $fechasPorAsignar;

            foreach ($fechasTemporales as $key => $fechaValor) {
                if (($diasAUsar + $fechaValor['valor']) <= $diasDisponiblesPeriodo) {
                    $diasAUsar += $fechaValor['valor'];
                    $fechasParaEstePeriodo->push($fechaValor);
                    $fechasPorAsignar->forget($key);
                } else {
                    break;
                }
            }


            if ($fechasParaEstePeriodo->isEmpty()) continue;

            $fechaFinal = $fechasParaEstePeriodo->last()['fecha'];
            $fechaRetorno = $fechaFinal->copy()->addDay();

            $solicitud = new SolicitudVacaciones();
            $solicitud->EMPRESA = $ficha->EMPRESA;
            $solicitud->FICHA = $ficha->NUMERO;
            $solicitud->FECHA_INICIO = $fechasParaEstePeriodo->first()['fecha']->format('Y-m-d');
            $solicitud->FECHA_PAGO = $fechasParaEstePeriodo->first()['fecha']->format('Y-m-d');
            $solicitud->FECHA_FIN = $fechasParaEstePeriodo->last()['fecha']->format('Y-m-d');
            $solicitud->DIAS_OTORGADOS = 0;
            $solicitud->FECHA_RETORNO = $fechaRetorno->format('Y-m-d');
            $solicitud->ESTATUS = 'A';
            $solicitud->DIA_SOLICITUD = $diasAUsar;
            $solicitud->PERIODO = $periodo->PERIODO;
            $solicitud->save();




            $solicitudWeb = new VacacionH();
            $solicitudWeb->empresa = $ficha->EMPRESA;
            $solicitudWeb->ficha = $ficha->NUMERO;
            $solicitudWeb->fecha_inicio = $fechasParaEstePeriodo->first()['fecha']->format('Y-m-d');
            $solicitudWeb->fecha_fin = $fechasParaEstePeriodo->last()['fecha']->format('Y-m-d');
            $solicitudWeb->dias_solicitados = $diasAUsar;
            $solicitudWeb->periodo = $periodo->PERIODO;
            $solicitudWeb->usuario_solicita = auth()->user()->id;
            $solicitudWeb->vacacion = $solicitud->DFRECNUM;
            $solicitudWeb->motivo = $request->solicitud_para;
            $solicitudWeb->detalle_motivo = $request->detalle_solicitud;
            $solicitudWeb->save();

            foreach ($fechasParaEstePeriodo as $fechaValor) {
                DB::table('VACAC_D')->insert([
                    'FICHA' => $ficha->NUMERO,
                    'FECHA_INICIO' => $fechaValor['fecha']->format('Y-m-d'),
                    'DIA' => $fechaValor['fecha']->format('Y-m-d'),
                    'TIEMPO' => $fechaValor['valor'],
                    'VACACION' => $solicitud->DFRECNUM,
                    'TOTAL' => $fechaValor['valor'],
                ]);

                $detalleSolicitud = new VacacionD();
                $detalleSolicitud->vacaciones_h_id = $solicitudWeb->id;
                $detalleSolicitud->fecha = $fechaValor['fecha']->format('Y-m-d');
                $detalleSolicitud->valor = $fechaValor['valor'];
                $detalleSolicitud->save();
            }

            $solicitudesCreadas[] = $solicitud->DFRECNUM;
        }

        $archivo = $request->file('formato');
        $rutaArchivo = $archivo->store("solicitud_vacaciones/$solicitudWeb->id");
        $solicitudWeb->url = $rutaArchivo;
        $solicitudWeb->save();

        return response()->json([
            'success' => true,
            'message' => 'Solicitud(es) de vacaciones creada(s) exitosamente',
            'redirect' => route('solicitud_vacaciones.index'),
            'count' => count($solicitudesCreadas)
        ]);

    }

    public function edit(VacacionH $solicitud)
    {
        return view('solicitud_vacaciones.edit')->with(['solicitud' => $solicitud]);
    }

    public function solicitudEnPDF($fechas, $permiso, $detalle)
    {
        $fechasArray = json_decode(urldecode($fechas), true);
        $empresa = DB::connection('sqlsrv-secondary')->table('EMPRESA')->where('NUMERO', 1)->first();
        $ficha = Ficha::find(auth()->user()->fichaActiva());


        view()->share(['data' => $fechasArray, 'ficha' => $ficha, 'para' => $permiso, 'detalle' => $detalle, 'parametros' => ['empresa' => $empresa]]);
        $pdf = PDF::loadView('reportes.formato_solicitud')->setPaper('a4', 'portrait');
        return $pdf->stream('solicitud.pdf');
    }
}
