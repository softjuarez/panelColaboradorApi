<?php

namespace App\Observers;

use App\Models\ArchivoRequisicion;
use App\Models\BitacoraRequisicion;
use Carbon\Carbon;

class ArchivoRequisicionObserver
{
    /**
     * Handle the ArchivoRequisicion "created" event.
     */
    public function created(ArchivoRequisicion $archivoRequisicion): void
    {
        BitacoraRequisicion::create([
            'requisicion_h' =>  $archivoRequisicion->requisicion_h,
            'entidad_id' =>  $archivoRequisicion->id,
            'fecha' => Carbon::now(),
            'usuario' => auth()->user()->id,
            'accion' => 'Crear',
            'modelo' => 'ArchivoRequisicion',
            'descripcion' => "Se cargo el archivo de la requisición con el nombre: $archivoRequisicion->nombre",  
        ]);
    }

    /**
     * Handle the ArchivoRequisicion "updated" event.
     */
    public function updated(ArchivoRequisicion $archivoRequisicion): void
    {
        //
    }

    /**
     * Handle the ArchivoRequisicion "deleted" event.
     */
    public function deleted(ArchivoRequisicion $archivoRequisicion): void
    {
        BitacoraRequisicion::create([
            'requisicion_h' =>  $archivoRequisicion->requisicion_h,
            'entidad_id' =>  $archivoRequisicion->id,
            'fecha' => Carbon::now(),
            'usuario' => auth()->user()->id,
            'accion' => 'Eliminar',
            'modelo' => 'ArchivoRequisicion',
            'descripcion' => "Se elimino el archivo de la requisición con el nombre: $archivoRequisicion->nombre",  
        ]);
    }

    /**
     * Handle the ArchivoRequisicion "restored" event.
     */
    public function restored(ArchivoRequisicion $archivoRequisicion): void
    {
        //
    }

    /**
     * Handle the ArchivoRequisicion "force deleted" event.
     */
    public function forceDeleted(ArchivoRequisicion $archivoRequisicion): void
    {
        //
    }
}
