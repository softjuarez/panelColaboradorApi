<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoPermiso;
use App\Models\SolicitudPermisos;

class TipoPermisoController extends Controller
{
    public function index()
    {
        $tiposPermiso = TipoPermiso::paginate(15);
        return view('tipo_permisos.index')->with('tipo_permisos', $tiposPermiso);
    }

    public function new()
    {
        return view('tipo_permisos.new');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tipo_permiso = TipoPermiso::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('tipo_permisos.edit', $tipo_permiso)->with(['status' => 'success', 'message' => 'Tipo de permiso creado correctamente.']);
    }

    public function edit(TipoPermiso $tipo_permiso)
    {
        return view('tipo_permisos.edit')->with('tipo_permiso', $tipo_permiso);
    }

    public function update(Request $request, TipoPermiso $tipo_permiso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tipo_permiso->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('tipo_permisos.edit', $tipo_permiso)->with(['status' => 'success', 'message' => 'Tipo de permiso actualizado correctamente.']);
    }

    public function delete(TipoPermiso $tipo_permiso)
    {
        $existeSolicitud = SolicitudPermisos::where('tipo', $tipo_permiso->id)->exists();
        if ($existeSolicitud) {
            return redirect()->route('tipo_permisos.index')->with(['status' => 'error', 'message' => 'No se puede eliminar el tipo de permiso porque existen solicitudes asociadas.']);
        }

        $tipo_permiso->delete();

        return redirect()->route('tipo_permisos.index')->with(['status' => 'success', 'message' => 'Tipo de permiso eliminado correctamente.']);
    }
}
