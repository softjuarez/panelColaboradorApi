<?php

namespace App\Observers;

use App\Models\BitacoraRequisicion;
use App\Models\RequisicionD;
use Carbon\Carbon;

class RequisicionDObserver
{
    /**
     * Handle the RequisicionD "created" event.
     */
    public function created(RequisicionD $requisicionD): void
    {
        BitacoraRequisicion::create([
            'requisicion_h' =>  $requisicionD->REQ_H,
            'entidad_id' =>  $requisicionD->NUMERO,
            'fecha' => Carbon::now(),
            'usuario' => auth()->user()->id,
            'accion' => 'Crear',
            'modelo' => 'RequisicionD',
            'descripcion' => "Se creo el detalle de la requisición con la descripcion: $requisicionD->DESCRIPCION",  
        ]);
    }

    /**
     * Handle the RequisicionD "updated" event.
     */
    public function updated(RequisicionD $requisicionD): void
    {
        BitacoraRequisicion::create([
            'requisicion_h' =>  $requisicionD->REQ_H,
            'entidad_id' =>  $requisicionD->NUMERO,
            'fecha' => Carbon::now(),
            'usuario' => auth()->user()->id,
            'accion' => 'Editar',
            'modelo' => 'RequisicionD',
            'descripcion' => "Se edito el detalle de la requisición con la descripcion: $requisicionD->DESCRIPCION",  
        ]);
    }

    /**
     * Handle the RequisicionD "deleted" event.
     */
    public function deleted(RequisicionD $requisicionD): void
    {
        BitacoraRequisicion::create([
            'requisicion_h' =>  $requisicionD->REQ_H,
            'entidad_id' =>  $requisicionD->NUMERO,
            'fecha' => Carbon::now(),
            'usuario' => auth()->user()->id,
            'accion' => 'Eliminar',
            'modelo' => 'RequisicionD',
            'descripcion' => "Se elimino el detalle de la requisición con la descripcion: $requisicionD->DESCRIPCION",  
        ]);
    }

    /**
     * Handle the RequisicionD "restored" event.
     */
    public function restored(RequisicionD $requisicionD): void
    {
        //
    }

    /**
     * Handle the RequisicionD "force deleted" event.
     */
    public function forceDeleted(RequisicionD $requisicionD): void
    {
        //
    }
}
