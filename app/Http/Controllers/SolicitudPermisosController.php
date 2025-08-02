<?php

namespace App\Http\Controllers;

use App\Models\SolicitudPermisos;
use App\Models\TipoPermiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudPermisosController extends Controller
{
    public function index($search = '')
    {
        $solicitudes = SolicitudPermisos::
                            join('ficha', 'ficha.NUMERO', '=', 'solicitud_permisos.ficha_crea')
                            ->where('ficha.NOMBRE', 'LIKE', '%'.$search.'%')
                            ->where('ficha_crea', auth()->user()->fichaActiva())
                            ->orderBy('created_at', 'desc')
                            ->paginate(15);

        return view('solicitud_permisos.index')->with(['solicitudes' => $solicitudes, 'search' => $search]);
    }

    public function new()
    {
        $tipos = TipoPermiso::all();
        return view('solicitud_permisos.new')->with(['tipos' => $tipos]);
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

        $solicitud = new SolicitudPermisos;
        $solicitud->ficha_crea = auth()->user()->fichaActiva();
        $solicitud->usuario_crea = auth()->user()->id;
        $solicitud->tipo = $request->tipo;
        $solicitud->descripcion = $request->descripcion;
        $solicitud->fecha_evento = $request->fecha ?? null;
        $solicitud->save();

        return redirect()->route('solicitud_permisos.edit', $solicitud)->with(['status' => 'success', 'message' => 'Solicitud creada exitosamente!']);
    }

    public function edit(SolicitudPermisos $solicitud)
    {
        $tipos = TipoPermiso::all();
        return view('solicitud_permisos.edit')->with(['solicitud' => $solicitud, 'tipos' => $tipos]);
    }

    public function update(Request $request, SolicitudPermisos $solicitud)
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

        return redirect()->route('solicitud_permisos.edit', $solicitud)->with(['status' => 'success', 'message' => 'Solicitud editada exitosamente!']);
    }

    public function delete(SolicitudPermisos $solicitud)
    {
        if ($solicitud->estatus != 'A') {
            return redirect()->route('solicitud_permisos.index')->with(['status' => 'error', 'message' => 'Solicitud no puede ser eliminada!']);
        }

        $solicitud->delete();
        return redirect()->route('solicitud_permisos.index')->with(['status' => 'success', 'message' => 'Solicitud eliminada exitosamente!']);
    }

    public function cerrar(SolicitudPermisos $solicitud)
    {
        $solicitud->RAZON_RECHAZO = '';
        $solicitud->ESTATUS = 'B';

        $solicitud->save();

        $configuracion = DB::table('configuraciones')->first();

        if (!empty($configuracion->notificar_solicitudes)){
            $correosValidos = array_filter(explode(';', $configuracion->notificar_solicitudes), function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            });

            //Mail::to($correosValidos)->send(new SolicitudProcesada($solicitud));
        }

        return redirect()->route('solicitud_permisos.edit', $solicitud)->with(['status' => 'success', 'message' => 'Se ha enviado la solicitud exitosamente!']);
    }
}
