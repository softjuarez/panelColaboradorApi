<?php

namespace App\Http\Controllers;

use App\Models\Licencia;
use App\Models\TipoLicencia;
use Illuminate\Http\Request;

class TipoLicenciaController extends Controller
{
        public function index()
    {
        $tipoLicencias = TipoLicencia::paginate(15);
        return view('tipo_licencias.index')->with('tipo_licencias', $tipoLicencias);
    }

    public function new()
    {
        return view('tipo_licencias.new');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'dias_ley' => 'required|integer|gt:0',
        ]);

        $tipo_licencia = TipoLicencia::create([
            'nombre' => $request->nombre,
            'dias_ley' => $request->dias_ley,
        ]);

        return redirect()->route('tipo_licencias.edit', $tipo_licencia)->with(['status' => 'success', 'message' => 'Tipo de permiso creado correctamente.']);
    }

    public function edit(TipoLicencia $tipo_licencia)
    {
        return view('tipo_licencias.edit')->with('tipo_licencia', $tipo_licencia);
    }

    public function update(Request $request, TipoLicencia $tipo_licencia)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'dias_ley' => 'required|integer|gt:0',
        ]);

        $tipo_licencia->update([
            'nombre' => $request->nombre,
            'dias_ley' => $request->dias_ley,
        ]);

        return redirect()->route('tipo_licencias.edit', $tipo_licencia)->with(['status' => 'success', 'message' => 'Tipo de permiso actualizado correctamente.']);
    }

    public function delete(TipoLicencia $tipo_licencia)
    {
        $existeLicencia = Licencia::where('tipo', $tipo_licencia->id)->exists();
        if ($existeLicencia) {
            return redirect()->route('tipo_licencias.index')->with(['status' => 'error', 'message' => 'No se puede eliminar el tipo de permiso porque existen solicitudes asociadas.']);
        }

        $tipo_licencia->delete();

        return redirect()->route('tipo_licencias.index')->with(['status' => 'success', 'message' => 'Tipo de permiso eliminado correctamente.']);
    }
}
