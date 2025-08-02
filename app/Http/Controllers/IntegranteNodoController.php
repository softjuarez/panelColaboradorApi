<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use App\Models\IntegranteNodo;
use App\Models\Nodo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IntegranteNodoController extends Controller
{
    public function index(Nodo $nodo)
    {
        $integrantes = IntegranteNodo::where('nodo_id', $nodo->id)->orderBy('orden', 'asc')->get();
        return response()->json($integrantes);
    }

    public function store(Request $request, Nodo $nodo)
    {
        $request->validate([
            'ficha_id' => 'nullable|exists:FICHA,NUMERO',
            'nombre' => 'required_without:ficha_id|string|max:255',
            'puesto' => 'required|string|max:255',
            'orden' => 'nullable|integer',
        ]);

        $ficha = false;
        if ($request->ficha_id){
            $ficha = Ficha::where('NUMERO', $request->ficha_id)->first();
        }

        $integrante = new IntegranteNodo();
        $integrante->nodo_id = $nodo->id;
        $integrante->ficha_id = $request->ficha_id;
        $integrante->nombre = $ficha ? Str::title($ficha->NOMBRE) : $request->nombre;
        $integrante->puesto = $request->puesto;
        $integrante->coordinador = $request->coordinador;
        $integrante->orden = $request->orden;
        $integrante->save();

        return response()->json([
            'integrante' => $integrante,
            'message' => 'Integrante agregado correctamente'
        ], 201);
    }

    public function update(Request $request, IntegranteNodo $integrante)
    {
        $request->validate([
            'ficha_id' => 'nullable|exists:FICHA,NUMERO',
            'nombre' => 'required_without:ficha_id|string|max:255',
            'puesto' => 'required|string|max:255',
            'orden' => 'nullable|integer',
        ]);

        $ficha = false;
        if ($request->ficha_id){
            $ficha = Ficha::where('NUMERO', $request->ficha_id)->first();
        }

        $integrante->ficha_id = $request->ficha_id;
        $integrante->nombre = $ficha ? Str::title($ficha->NOMBRE) : $request->nombre;
        $integrante->puesto = $request->puesto;
        $integrante->coordinador = $request->coordinador;
        $integrante->orden = $request->orden;
        $integrante->save();

        return response()->json([
            'integrante' => $integrante,
            'message' => 'Integrante agregado correctamente'
        ], 201);
    }

    public function delete(IntegranteNodo $integrante)
    {
        $integrante->delete();
        return response()->json(['message' => 'Nodo eliminado.'], 200);
    }
}
