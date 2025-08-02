<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adjunto;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Storage;


class AdjuntoSolicitudController extends Controller
{
    public function store(Request $request, Solicitud $solicitud)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'adjunto' => ['required', 'file', 'max:2048'],
            'tipo_adjunto' => ['required'],            
        ]);

        $archivo = $request->file('adjunto');
        $rutaArchivo = $archivo->store("adjuntos/$solicitud->ficha_crea");

        $adjunto = new Adjunto([
            'nombre' => $request->nombre,
            'url' => $rutaArchivo,
            'ficha_id' => $solicitud->ficha_crea,
            'tipo_id' => $request->tipo_adjunto,
            'usuario_id' => auth()->user()->id,
            'para_todos' => 'N'
        ]);

        $solicitud->documentos()->save($adjunto);

        return $this->listado($solicitud);
    }

    public function listado(Solicitud $solicitud)
    {
        // Obtener el número de página actual desde la solicitud (por defecto 1)
        $page = request()->get('page', 1);
        // Número de elementos por página
        $perPage = request()->get('per_page', 5);

        // Obtener los archivos paginados
        $archivos = Adjunto::where('ficha_id', $solicitud->ficha_crea)
            ->where('adjuntable_id', $solicitud->id)
            ->where('adjuntable_type', Solicitud::class)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        // Transformar los archivos para incluir la URL de descarga
        $archivos->getCollection()->transform(function ($archivo) use ($solicitud) {
            $archivo->url_descarga = route('descargar.adjunto', [$solicitud->ficha_crea, basename($archivo->url)]);
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
