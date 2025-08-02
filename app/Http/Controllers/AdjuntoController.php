<?php

namespace App\Http\Controllers;

use App\Models\Adjunto;
use App\Models\Ficha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdjuntoController extends Controller
{
    public function index($search = '')
    {
        $adjuntos = Adjunto::where(function ($query) {
            $query->where('para_todos', 'S')
                  ->orWhere('ficha_id', auth()->user()->fichaActiva());
        })
        ->where('nombre', 'LIKE', '%'.$search.'%')
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        return view('adjuntos.index')->with(['adjuntos' => $adjuntos, 'search' => $search]);
    }

    public function store(Request $request, Ficha $ficha)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'adjunto' => ['required', 'file', 'max:2048'],
            'tipo_adjunto' => ['required'],
            'chequeo' => 'required|in:S,N',
            
        ]);

        $archivo = $request->file('adjunto');
        $rutaArchivo = $archivo->store("adjuntos/$ficha->NUMERO");

        $adjunto = new Adjunto([
            'nombre' => $request->nombre,
            'url' => $rutaArchivo,
            'ficha_id' => $ficha->NUMERO,
            'tipo_id' => $request->tipo_adjunto,
            'usuario_id' => auth()->user()->id,
            'para_todos' => $request->chequeo
        ]);

        $ficha->adjuntos()->save($adjunto);

        return $this->listado($ficha);
    }

    public function listado(Ficha $ficha)
    {
        // Obtener el número de página actual desde la solicitud (por defecto 1)
        $page = request()->get('page', 1);
        // Número de elementos por página
        $perPage = request()->get('per_page', 5);

        // Obtener los archivos paginados
        $archivos = Adjunto::where('ficha_id', $ficha->NUMERO)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        // Transformar los archivos para incluir la URL de descarga
        $archivos->getCollection()->transform(function ($archivo) use ($ficha) {
            $archivo->url_descarga = route('descargar.adjunto', [$ficha->NUMERO, basename($archivo->url)]);
            return $archivo;
        });

        // Devolver la respuesta JSON con los archivos y la información de paginación
        return response()->json([
            'archivos' => $archivos->items(), // Los archivos de la página actual
            'pagination' => [
                'total' => $archivos->total(), // Total de archivos
                'per_page' => $archivos->perPage(), // Elementos por página
                'current_page' => $archivos->currentPage(), // Página actual
                'last_page' => $archivos->lastPage(), // Última página
            ],
            'errors' => [],
        ]);
    }

    public function delete(Adjunto $adjunto)
    {
        $adjunto->delete();
        Storage::delete($adjunto->url);
        return response()->json(['errors' => []]);
    }
}
