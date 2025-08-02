<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConexionNodoRequest;
use App\Models\ConexionNodo;
use App\Models\Organigrama;
use Illuminate\Http\Request;

class ConexionNodoController extends Controller
{
    public function index(Organigrama $organigrama)
    {
        $conexiones = ConexionNodo::where('organigrama_id', $organigrama->id)->get();
        return response()->json(['estatus' => true, 'conexiones' => $conexiones], 200);
    }

    public function store(ConexionNodoRequest $request, Organigrama $organigrama)
    {
        $conexion = ConexionNodo::firstOrCreate([
            'organigrama_id' => $organigrama->id,
            'nodo_padre_id'  => $request->nodo_padre,
            'nodo_hijo_id'   => $request->nodo_hijo,
        ]);

        return response()->json([
            'success' => true,
            'id' => $conexion->id,
            'message' => 'Conexión creada exitosamente'
        ]);
    }

    public function delete(ConexionNodo $conexion)
    {
        $conexion->delete();
        return response()->json(['estatus' => true], 200);
    }
}
