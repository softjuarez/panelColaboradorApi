<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NoticiaController extends Controller
{
    public function index()
    {
        $noticias = Noticia::paginate(15);
        return view('noticias.index')->with(['noticias' => $noticias]);
    }

    public function new()
    {
        return view('noticias.new');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_vence' => 'required|date'
        ]);


        $noticia = new Noticia();
        $noticia->titulo = $request->titulo;
        $noticia->contenido = $request->contenido;
        $noticia->fecha_vencimiento = $request->fecha_vence;
        $noticia->creador = auth()->user()->id;
        $noticia->save();

        return redirect()->route('noticias.edit', $noticia)->with(['status' => 'success', 'message' => 'Noticia was successfully created!']);
    }

    public function edit(Noticia $noticia)
    {
        return view('noticias.edit')->with(['noticia' => $noticia]);
    }

    public function update(Request $request, Noticia $noticia)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_vence' => 'required|date'
        ]);

        $noticia->titulo = $request->titulo;
        $noticia->contenido = $request->contenido;
        $noticia->fecha_vencimiento = $request->fecha_vence;
        $noticia->save();

        return redirect()->route('noticias.edit', $noticia)->with(['status' => 'success', 'message' => 'Noticia was successfully updated!']);
    }
}
