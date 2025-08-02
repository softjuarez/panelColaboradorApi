<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionUsuarioController extends Controller
{
    public function mostrarBandejaNoticias(Request $request)
    {
        $request->validate([
            'estado' => 'required|string'
        ]);

        auth()->user()->configuracion->update(['mostrar_bandeja_noticias' => $request->estado]);
        
        return response()->json(['message' => 'Vista registrada']);
    }
}
