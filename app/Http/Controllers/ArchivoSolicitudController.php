<?php

namespace App\Http\Controllers;

use App\Models\ArchivoSolicitud;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArchivoSolicitudController extends Controller
{
    public function store(Request $request, Solicitud $solicitud)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'adjunto' => ['required', 'file', 'max:2048']
            
        ]);

        $archivo = $request->file('adjunto');
        $rutaArchivo = $archivo->store("adjuntos/$solicitud->ficha_crea");

        ArchivoSolicitud::create([
            'nombre' => $request->nombre,
            'url' => $rutaArchivo,
            'solicitud_id' => $solicitud->id,
        ]);

        return $this->listado($solicitud);
    }

    public function listado(Solicitud $solicitud)
    {
        // Obtener el número de página actual desde la solicitud (por defecto 1)
        $page = request()->get('page', 1);
        // Número de elementos por página
        $perPage = request()->get('per_page', 5);

        // Obtener los archivos paginados
        $archivos = ArchivoSolicitud::where('solicitud_id', $solicitud->id)
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

    public function delete(ArchivoSolicitud $archivo)
    {
        $archivo->delete();
        Storage::delete($archivo->url);
        return response()->json(['errors' => []]);
    }
}
