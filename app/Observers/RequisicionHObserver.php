<?php

namespace App\Observers;

use App\Models\BitacoraRequisicion;
use App\Models\RequisicionH;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RequisicionHObserver
{
    /**
     * Handle the RequisicionH "created" event.
     */
    public function created(RequisicionH $requisicionH): void
    {
        BitacoraRequisicion::create([
            'requisicion_h' =>  $requisicionH->NUMERO,
            'entidad_id' =>  $requisicionH->NUMERO,
            'fecha' => Carbon::now(),
            'usuario' => auth()->user()->id,
            'accion' => 'Crear',
            'modelo' => 'RequisicionH',
            'descripcion' => "Se creo la requisición con el numero $requisicionH->NUMERO",
        ]);
    }

    /**
     * Handle the RequisicionH "updated" event.
     */
    public function updated(RequisicionH $requisicionH): void
    {
        if ($requisicionH->isDirty('ESTATUS')) {
            $mensaje = "";
            $accion = "";

            $usuario = User::find($requisicionH->ficha->referencia());

            switch ($requisicionH->ESTATUS) {
                case 'B':
                    $mensaje = "Se cerró la requisición con el número $requisicionH->NUMERO";
                    $accion = "Autorizacion Enviada";
                    break;

                case 'C':
                    if ($usuario->jefe_id == $usuario->id) {
                        $mensaje = "Se autorizó automáticamente la requisición con el número $requisicionH->NUMERO (el usuario es su propio jefe)";
                        $accion = "Autorizar Automáticamente Jefe";
                    } else {
                        $mensaje = "Se autorizó la requisición con el número $requisicionH->NUMERO, por motivo $requisicionH->RAZON_AUTORIZA";
                        $accion = "Autorizacion Jefe";
                    }
                    break;

                case 'D':
                    $mensaje = "Se autorizó la requisición con el número $requisicionH->NUMERO";
                    $accion = "Autorizacion Presupuesto";
                    break;

                case 'E':
                    $mensaje = "Se autorizó la requisición con el número $requisicionH->NUMERO";
                    $accion = "Autorizacion Tesoreria";
                    break;

                case 'F':
                    $mensaje = "Se autorizó la requisición con el número $requisicionH->NUMERO";
                    $accion = "Autorizacion Compras";
                    break;

                case 'G':
                    $mensaje = "Se autorizó la requisición con el número $requisicionH->NUMERO";
                    $accion = "Autorizacion Gestor";
                    break;

                case 'H':
                    $mensaje = "Se autorizó la requisición con el número $requisicionH->NUMERO";
                    $accion = "Autorizacion Compras";
                    break;

                case 'I':
                    $mensaje = "Se autorizó la requisición con el número $requisicionH->NUMERO";
                    $accion = "Autorizacion Comite";
                    break;

                default:
                    $mensaje = "Se editó la requisición con el número $requisicionH->NUMERO";
                    $accion = "Editar";
                    break;
            }

            if (!empty($requisicionH->RAZON_RECHAZO)) {
                $mensaje = "Se rechazó la requisición con el número $requisicionH->NUMERO por la razón: $requisicionH->RAZON_RECHAZO";
                $accion = "Rechazar";
            }

            if (!empty($mensaje) && !empty($accion)) {
                BitacoraRequisicion::create([
                    'requisicion_h' => $requisicionH->NUMERO,
                    'entidad_id' => $requisicionH->NUMERO,
                    'fecha' => Carbon::now(),
                    'usuario' => auth()->user()->id,
                    'accion' => $accion,
                    'modelo' => 'RequisicionH',
                    'descripcion' => $mensaje,
                ]);
            }
        }
    }

    /**
     * Handle the RequisicionH "deleted" event.
     */
    public function deleted(RequisicionH $requisicionH): void
    {
        //
    }

    /**
     * Handle the RequisicionH "restored" event.
     */
    public function restored(RequisicionH $requisicionH): void
    {
        //
    }

    /**
     * Handle the RequisicionH "force deleted" event.
     */
    public function forceDeleted(RequisicionH $requisicionH): void
    {
        //
    }
}
