<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\TipoSolicitud;
use Illuminate\Support\Facades\Mail;
use App\Mail\SolicitudProcesada;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SolicitudController extends Controller
{
    public function index($search = '')
    {
        $solicitudes = Solicitud::
                            join('ficha', 'ficha.NUMERO', '=', 'solicitud.ficha_crea')
                            ->where('ficha.NOMBRE', 'LIKE', '%'.$search.'%')
                            ->where('ficha_crea', auth()->user()->fichaActiva())
                            ->orderBy('created_at', 'desc')
                            ->paginate(15);

        return view('solicitudes.index')->with(['solicitudes' => $solicitudes, 'search' => $search]);
    }

    public function new()
    {
        $tipos = TipoSolicitud::all();
        return view('solicitudes.new')->with(['tipos' => $tipos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|integer',
            'fecha' => 'nullable|date',
            'descripcion' => 'required|string|min:15'
        ]);

        if (auth()->user()->fichaActiva() == 0) {
            return redirect()->back()
                ->withErrors(['ficha_activa' => 'Debe tener una ficha seleccionada.'])
                ->withInput();
        }

        $solicitud = new Solicitud;
        $solicitud->ficha_crea = auth()->user()->fichaActiva();
        $solicitud->usuario_crea = auth()->user()->id;
        $solicitud->tipo = $request->tipo;
        $solicitud->descripcion = $request->descripcion;
        $solicitud->fecha_evento = $request->fecha ?? null;
        $solicitud->save();

        return redirect()->route('solicitudes.edit', $solicitud)->with(['status' => 'success', 'message' => 'Solicitud creada exitosamente!']);
    }

    public function edit(Solicitud $solicitud)
    {
        $tipos = TipoSolicitud::all();
        return view('solicitudes.edit')->with(['solicitud' => $solicitud, 'tipos' => $tipos]);
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        $request->validate([
            'tipo' => 'required|integer',
            'fecha' => 'nullable|date',
            'descripcion' => 'required|string|min:15'
        ]);

        $solicitud->tipo = $request->tipo;
        $solicitud->descripcion = $request->descripcion;
        $solicitud->fecha_evento = $request->fecha ?? null;
        $solicitud->save();

        return redirect()->route('solicitudes.edit', $solicitud)->with(['status' => 'success', 'message' => 'Solicitud editada exitosamente!']);
    }

    public function delete(Solicitud $solicitud)
    {
        if ($solicitud->estatus != 'A') {
            return redirect()->route('solicitudes.index')->with(['status' => 'error', 'message' => 'Solicitud no puede ser eliminada!']);
        }

        $solicitud->delete();
        return redirect()->route('solicitudes.index')->with(['status' => 'success', 'message' => 'Solicitud eliminada exitosamente!']);
    }

    public function cerrar(Solicitud $solicitud)
    {
        $solicitud->RAZON_RECHAZO = '';
        $solicitud->ESTATUS = 'B';
        $solicitud->save();

        $configuracion = DB::table('configuraciones')->first();

        if (!empty($configuracion->notificar_solicitudes)) {
            $correosValidos = array_filter(explode(';', $configuracion->notificar_solicitudes), function ($email) {
                return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
            });

            foreach ($correosValidos as $correo) {
                try {
                    Mail::to($correo)->send(new SolicitudProcesada($solicitud));
                } catch (\Exception $e) {
                    Log::error("Error al enviar correo a {$correo}: " . $e->getMessage());
                }
            }
        }

        return redirect()->route('solicitudes.edit', $solicitud)->with(['status' => 'success', 'message' => 'Se ha enviado la solicitud exitosamente!']);
    }
}
