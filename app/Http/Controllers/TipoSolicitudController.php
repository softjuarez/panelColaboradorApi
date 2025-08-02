<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoSolicitud;

class TipoSolicitudController extends Controller
{
    public function index()
    {
        $tipo_solicitudes = TipoSolicitud::paginate(15);
        return view('tipo_solicitudes.index')->with(['tipo_solicitudes' => $tipo_solicitudes]);
    }

    /**
     * Muestra el formulario para crear un nuevo tipo de adjunto.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        return view('tipo_solicitudes.new');
    }

    /**
     * Almacena un nuevo tipo de adjunto en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $TipoSolicitud = TipoSolicitud::create($request->all());

        return redirect()->route('tipo_solicitudes.edit', $TipoSolicitud)->with(['status' => 'success', 'message' => 'Tipo solicitud creado correctamente!']);
    }


    
    public function edit(TipoSolicitud $tipo_solicitud)
    {
        return view('tipo_solicitudes.edit')->with(['tipo_solicitud' => $tipo_solicitud]);
    }


    public function update(Request $request, TipoSolicitud $tipo_solicitud)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tipo_solicitud->update($request->all());

        return redirect()->route('tipo_solicitudes.edit', $tipo_solicitud)->with(['status' => 'success', 'message' => 'Tipo solicitud editado correctamente!']);
    }

 
    public function delete(TipoSolicitud $tipo_solicitud)
    {
        if ($tipo_solicitud->solicitudes()->count() > 0) {
            return redirect()->route('tipo_solicitudes.index')->with(['status' => 'error', 'message' => 'Tipo solicitud ya tiene solicitudes asignadas!']);
        }

        $tipo_solicitud->delete();
        return redirect()->route('tipo_solicitudes.index')->with(['status' => 'success', 'message' => 'Tipo solicitud eliminado correctamente!']);
    }
}
