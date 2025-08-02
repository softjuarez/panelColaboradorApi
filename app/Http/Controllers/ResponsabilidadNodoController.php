<?php

namespace App\Http\Controllers;

use App\Models\Nodo;
use App\Models\ResponsabilidadNodo;
use Illuminate\Http\Request;

class ResponsabilidadNodoController extends Controller
{
    public function index(Nodo $nodo)
    {
        $responsabilidades = ResponsabilidadNodo::where('nodo_id', $nodo->id)->get();
        return response()->json($responsabilidades);
    }

    public function store(Request $request, Nodo $nodo)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'orden' => 'nullable|integer',
        ]);

        $responsabilidad = new ResponsabilidadNodo();
        $responsabilidad->nodo_id = $nodo->id;
        $responsabilidad->descripcion = $request->descripcion;
        $responsabilidad->orden = $request->orden;
        $responsabilidad->save();

        return response()->json([
            'responsabilidad' => $responsabilidad,
            'message' => 'Responsabilidad agregado correctamente'
        ], 201);
    }

    public function update(Request $request, ResponsabilidadNodo $responsabilidad)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'orden' => 'nullable|integer',
        ]);

        $responsabilidad->descripcion = $request->descripcion;
        $responsabilidad->orden = $request->orden;
        $responsabilidad->save();

        return response()->json([
            'responsabilidad' => $responsabilidad,
            'message' => 'Responsabilidad agregado correctamente'
        ], 201);
    }

    public function delete(ResponsabilidadNodo $responsabilidad)
    {
        $responsabilidad->delete();
        return response()->json(['message' => 'Responsabilidad eliminado.'], 200);
    }
}
