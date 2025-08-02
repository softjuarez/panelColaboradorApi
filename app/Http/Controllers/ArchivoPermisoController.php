<?php

namespace App\Http\Controllers;

use App\Models\ArchivoPermiso;
use App\Models\SolicitudPermisos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoPermisoController extends Controller
{
    public function store(Request $request, SolicitudPermisos $solicitud)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'adjunto' => ['required', 'file', 'max:2048']

        ]);

        $archivo = $request->file('adjunto');
        $rutaArchivo = $archivo->store("adjuntos/$solicitud->ficha_crea");

        ArchivoPermiso::create([
            'nombre' => $request->nombre,
            'url' => $rutaArchivo,
            'permiso_id' => $solicitud->id,
        ]);

        return $this->listado($solicitud);
    }

    public function listado(SolicitudPermisos $solicitud)
    {
        $page = request()->get('page', 1);
        $perPage = request()->get('per_page', 5);

        $archivos = ArchivoPermiso::where('permiso_id', $solicitud->id)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        $archivos->getCollection()->transform(function ($archivo) use ($solicitud) {
            $archivo->url_descarga = route('descargar.adjunto', [$solicitud->ficha_crea, basename($archivo->url)]);
            return $archivo;
        });

        return response()->json([
            'archivos' => $archivos->items(),
            'pagination' => [
                'total' => $archivos->total(),
                'per_page' => $archivos->perPage(),
                'current_page' => $archivos->currentPage(),
                'last_page' => $archivos->lastPage(),
            ],
            'errors' => [],
        ]);
    }

    public function delete(ArchivoPermiso $archivo)
    {
        $archivo->delete();
        Storage::delete($archivo->url);
        return response()->json(['errors' => []]);
    }
}
