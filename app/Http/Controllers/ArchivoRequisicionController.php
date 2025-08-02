<?php

namespace App\Http\Controllers;

use App\Models\ArchivoRequisicion;
use App\Models\RequisicionH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArchivoRequisicionController extends Controller
{
    public function index(RequisicionH $requisicion)
    {
        $archivos = ArchivoRequisicion::where('requisicion_h', $requisicion->NUMERO)->get();
        
        $archivos->transform(function ($archivo) {
            $archivo->url_descarga = route('descargar.archivo', basename($archivo->url));
            return $archivo;
        });
    
        return response()->json($archivos);
    }

    public function store(Request $request, RequisicionH $requisicion)
    {
        $request->validate([
            'nombre' => ['required'],
            'archivo' => ['required', 'file', 'max:2048'],
        ]);

        $archivo = $request->file('archivo');
        $rutaArchivo = $archivo->store('archivos_requisicion');

        ArchivoRequisicion::create([
            'nombre' => $request->nombre,
            'url' => $rutaArchivo,
            'requisicion_h' => $requisicion->NUMERO,
            'etapa' => $requisicion->ESTATUS,
            'user_id' => auth()->user()->id
        ]);

        $archivos = ArchivoRequisicion::where('requisicion_h', $requisicion->NUMERO)->get();
        
        $archivos->transform(function ($archivo) {
            $archivo->url_descarga = route('descargar.archivo', basename($archivo->url));
            return $archivo;
        });

        return response()->json(['archivos' => $archivos, 'errors' => []]);
    }

    public function delete(ArchivoRequisicion $archivo)
    {
        $archivo->delete();
        Storage::delete($archivo->url);
        return response()->json(['errors' => []]);
    }
}
