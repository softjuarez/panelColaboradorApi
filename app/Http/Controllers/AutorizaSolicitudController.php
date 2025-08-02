<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\TipoAdjunto;
use Illuminate\Support\Facades\Mail;
use App\Mail\SolicitudRechazada;
use App\Mail\SolicitudAceptada;
use Illuminate\Support\Facades\Log;

class AutorizaSolicitudController extends Controller
{
    public function index($estado = 0, $search = '')
    {
        $query = Solicitud::join('ficha', 'ficha.NUMERO', '=', 'solicitud.ficha_crea')
                        ->where('ficha.NOMBRE', 'LIKE', '%' . $search . '%');

        if ($estado == 0) {
            $query->whereIn('solicitud.estatus', ['B']);
        } else {
            $query->whereIn('solicitud.estatus', ['B', 'C']);
        }

        $solicitudes = $query->orderBy('solicitud.created_at', 'desc')
                            ->paginate(15);

        return view('autoriza_solicitudes.index', [
            'solicitudes' => $solicitudes,
            'search' => $search,
            'estado' => $estado,
        ]);
    }

    public function edit(Solicitud $solicitud)
    {
        $tipo_adjuntos = TipoAdjunto::all();
        return view('autoriza_solicitudes.edit')->with(['solicitud' => $solicitud, 'tipo_adjuntos' => $tipo_adjuntos]);
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        $request->validate([
            'respuesta' => 'required|string|min:15'
        ]);

        $solicitud->respuesta = $request->respuesta;
        $solicitud->usuario_atendio = auth()->user()->id;
        $solicitud->fecha_atendio = date('Y-m-d');
        $solicitud->save();

        return redirect()->route('autoriza_solicitudes.edit', $solicitud)->with(['status' => 'success', 'message' => 'Solicitud editada exitosamente!']);
    }

    public function autorizar(Solicitud $solicitud)
    {
        if (empty($solicitud->respuesta)) {
            return redirect()->route('autoriza_solicitudes.edit', $solicitud)->with(['status' => 'error', 'message' => 'La solicitud debe tener una respuesta.']);
        }

        $solicitud->estatus = 'C';
        $solicitud->save();


        try {
            Mail::to($solicitud->usuario->email)->send(new SolicitudAceptada($solicitud));
        } catch (\Exception $e) {
            Log::error("Error al enviar correo a {$solicitud->usuario->email}: " . $e->getMessage());
        }

        return redirect()->route('autoriza_solicitudes.edit', $solicitud)->with(['status' => 'success', 'message' => 'Requisición autorizada correctamente.']);
    }

    public function rechazar(Request $request, Solicitud $solicitud)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:255',
        ]);

        $solicitud->estatus = 'A';
        $solicitud->razon_rechazo = $request->motivo_rechazo;
        $solicitud->save();

        try {
            Mail::to($solicitud->usuario->email)->send(new SolicitudRechazada($solicitud));
        } catch (\Exception $e) {
            Log::error("Error al enviar correo a {$solicitud->usuario->email}: " . $e->getMessage());
        }

        return redirect()->route('autoriza_solicitudes.edit', $solicitud)->with(['status' => 'success', 'message' => 'Solicitud rechazada correctamente.']);
    }
}
