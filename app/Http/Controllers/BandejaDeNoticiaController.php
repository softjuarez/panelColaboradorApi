<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\NoticiaVista;
use Illuminate\Http\Request;

class BandejaDeNoticiaController extends Controller
{
    public function index()
    {
        return view('bandeja_de_noticias.index');
    }

    public function obtenerNotificaciones()
    {
        $noticias = Noticia::selectRaw("*, (IIF((select count(*) from noticia_vistas where noticia_id = noticias.id and user_id = ". auth()->user()->id .") > 0, 'true', 'false')) as 'read'")->orderBy('created_at', 'desc')->with('Creador')->get();
        return response()->json($noticias);
    }

    public function marcarVista(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        NoticiaVista::firstOrCreate([
            'noticia_id' => $request->id,
            'user_id' => auth()->user()->id
        ], [
            'fecha_visto' => now() // Laravel helper para fecha/hora actual
        ]);
        
        return response()->json(['message' => 'Vista registrada']);
    }
}
