<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoAdjunto;

class TipoAdjuntoController extends Controller
{
    public function index()
    {
        $tiposAdjuntos = TipoAdjunto::paginate(15);
        return view('tipo_adjuntos.index')->with(['tipo_adjuntos' => $tiposAdjuntos]);
    }

    /**
     * Muestra el formulario para crear un nuevo tipo de adjunto.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        return view('tipo_adjuntos.new');
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

        $tipoAdjunto = TipoAdjunto::create($request->all());

        return redirect()->route('tipo_adjuntos.edit', $tipoAdjunto)->with(['status' => 'success', 'message' => 'Tipo adjuntos creado correctamente!']);
    }


    
    public function edit(TipoAdjunto $tipoAdjunto)
    {
        return view('tipo_adjuntos.edit')->with(['tipo_adjunto' => $tipoAdjunto]);
    }


    public function update(Request $request, TipoAdjunto $tipoAdjunto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tipoAdjunto->update($request->all());

        return redirect()->route('tipo_adjuntos.edit', $tipoAdjunto)->with(['status' => 'success', 'message' => 'Tipo adjuntos editado correctamente!']);
    }

 
    public function delete(TipoAdjunto $tipoAdjunto)
    {
        if ($tipoAdjunto->documentos()->count() > 0) {
            return redirect()->route('tipo_adjuntos.index')->with(['status' => 'error', 'message' => 'Tipo adjuntos ya tiene documentos asignados!']);
        }
        $tipoAdjunto->delete();

        return redirect()->route('tipo_adjuntos.index')->with(['status' => 'success', 'message' => 'Tipo adjuntos eliminado correctamente!']);
    }
}
