<?php

namespace App\Http\Controllers;

use App\Models\Feriado;
use App\Models\Ficha;
use App\Models\Licencia;
use App\Models\TipoLicencia;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;

class LicenciaController extends Controller
{
    public function index($search = '')
    {
        $licencias = Licencia::join('ficha', 'ficha.NUMERO', '=', 'licencias.ficha_crea')
                            ->where('ficha.NOMBRE', 'LIKE', '%'.$search.'%')
                            ->where('ficha_crea', auth()->user()->fichaActiva())
                            ->orderBy('created_at', 'desc')
                            ->paginate(15);

        return view('licencias.index')->with(['licencias' => $licencias, 'search' => $search]);
    }

    public function new()
    {
        $tipos = TipoLicencia::all();
        return view('licencias.new')->with(['tipos' => $tipos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => ['required'],
            'fecha_inicio' => ['required'],
            'descripcion' => ['required', 'min:15'],
        ]);

        if (auth()->user()->fichaActiva() == 0) {
            return redirect()->back()
                ->withErrors(['ficha_activa' => 'Debe tener una ficha seleccionada.'])
                ->withInput();
        }

        $licencia = new Licencia;
        $licencia->ficha_crea = auth()->user()->fichaActiva();
        $licencia->usuario_crea = auth()->user()->id;
        $licencia->tipo = $request->tipo;
        $licencia->descripcion = $request->descripcion;
        $licencia->fecha_evento = $request->fecha_inicio;
        $licencia->fecha_fin_evento = $this->calcularFechaFinLicencia($licencia);
        $licencia->save();

        return redirect()->route('licencias.edit', $licencia)->with(['status' => 'success', 'message' => 'Licencia Creada Correctamente!']);
    }

    public function edit(Licencia $licencia)
    {
        $tipos = TipoLicencia::all();
        return view('licencias.edit')->with(['licencia' => $licencia, 'tipos' => $tipos]);
    }

    public function update(Request $request, Licencia $licencia)
    {
        $request->validate([
            'tipo' => ['required'],
            'fecha_inicio' => ['required'],
            'descripcion' => ['required', 'min:15'],
        ]);

        $licencia->tipo = $request->tipo;
        $licencia->descripcion = $request->descripcion;
        $licencia->fecha_evento = $request->fecha_inicio;
        $licencia->fecha_fin_evento = $this->calcularFechaFinLicencia($licencia);
        $licencia->save();

        return redirect()->route('licencias.edit', $licencia)->with(['status' => 'success', 'message' => 'Gestor Creado Correctamente!']);
    }

    public function adjunto(Request $request, Licencia $licencia)
    {
        $request->validate([
            'adjunto' => ['required', 'file', 'max:2048']
        ]);

        $archivo = $request->file('adjunto');
        $rutaArchivo = $archivo->store("licencias/" . auth()->user()->fichaActiva());

        $licencia->url = $rutaArchivo;
        $licencia->save();

        return response()->json([
            'archivos' => $rutaArchivo,
            'errors' => [],
        ]);
    }

    public function cerrar(Licencia $licencia)
    {
        if (empty($licencia->url)){
            return redirect()->route('licencias.edit', $licencia)->with(['status' => 'error', 'message' => 'Debe agregar su adjunto de solicitud firmada!']);
        }

        $licencia->razon_rechazo = '';
        $licencia->estatus = 'B';

        $licencia->save();
        return redirect()->route('licencias.edit', $licencia)->with(['status' => 'success', 'message' => 'Se ha enviado la solicitud exitosamente!']);
    }

    public function solicitudEnPDF(Licencia $licencia)
    {
        $fechaCarbon = Carbon::parse($licencia->fecha_evento);
        view()->share(['licencia' => $licencia, 'ficha' => Ficha::find($licencia->ficha), 'fecha_inicio' => $fechaCarbon]);

        $pdf = PDF::loadView('reportes.licencia')->setPaper('a4', 'portrait');
        return $pdf->stream('licencia.pdf');
    }

    private function calcularFechaFinLicencia(Licencia $licencia)
    {
        $fechaInicio = Carbon::parse($licencia->fecha_evento);
        $fechaCalculada = $fechaInicio->copy();
        $diasSumados = 0;
        $diasLey = $licencia->tipo_licencia->dias_ley;

        $feriados = Feriado::whereDate('fecha', '>=', $fechaInicio)
                        ->pluck('fecha')
                        ->map(function ($fecha) {
                            return Carbon::parse($fecha)->format('Y-m-d');
                        })->toArray();

        while ($diasSumados < $diasLey) {
            $fechaCalculada->addDay();

            if (!$fechaCalculada->isWeekend() &&
                !in_array($fechaCalculada->format('Y-m-d'), $feriados)) {
                $diasSumados++;
            }
        }

        return $fechaCalculada;
    }
}
