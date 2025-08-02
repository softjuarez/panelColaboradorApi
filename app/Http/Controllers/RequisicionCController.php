<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequisicionD;
use App\Models\RequisicionC;
use Illuminate\Support\Facades\DB;

class RequisicionCController extends Controller
{
    public function index(RequisicionD $requisicion_d)
    {
        $detalles = $requisicion_d->detalles;
        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $detalles, 'errors' => []], 200);
    }

    public function store(Request $request, RequisicionD $requisicion_d)
    {
        $request->validate([
            'sugerido' => [
                'required',
                'in:S,N',
                function ($attribute, $value, $fail) use ($requisicion_d) {
                    if ($value == 'S') {
                        $exists = RequisicionC::where('REQ_D', $requisicion_d->NUMERO)
                            ->where('AUTORIZA1', 'S')
                            ->exists();

                        if ($exists) {
                            $fail('Ya existe un registro sugerido para este detalle.');
                        }
                    }
                },
            ],
            'proveedor' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($requisicion_d) {
                    $exists = RequisicionC::where('REQ_D', $requisicion_d->NUMERO)
                        ->where('PRVEEDOR', $value)
                        ->exists();

                    if ($exists) {
                        $fail('Ya existe un registro con este proveedor para esta requisición.');
                    }
                },
            ],
            'proveedor_nombre' => [
                'required_if:proveedor,4',
                'max:255'
            ],
            'precio_unitario' => 'required',
            'fecha_entrega' => 'required|date',
            'referencia' => 'required|string',
            'descripcion' => 'required|string|max:100',
        ]);

        $proveedor = DB::connection('sqlsrv-secondary')->table('PRVEEDOR')->where('NUMERO', $request->proveedor)->first();

        $detalle = new RequisicionC;
        $detalle->REQ_D = $requisicion_d->NUMERO;
        $detalle->RECURSO = 0;
        $detalle->PRVEEDOR = $request->proveedor;
        $detalle->PRVEEDOR_NOMBRE = $request->proveedor == 4 ? $request->proveedor_nombre : $proveedor->NOMBRE_COMPLETO;
        $detalle->PRIORIDAD = $requisicion_d->detalles()->max('PRIORIDAD') + 1;
        $detalle->PU = $request->precio_unitario;
        $detalle->COMENTARIOS = $request->descripcion;
        $detalle->AUTORIZA1 = $request->sugerido;
        $detalle->AUTORIZA2 = $request->sugerido;
        $detalle->MONEDA = 'Q';
        $detalle->TIPO_CAMBIO = 1;
        $detalle->PR_COTIZADO = 0;
        $detalle->FECHA_ENTREGA = $request->fecha_entrega;
        $detalle->REFERENCIA_PR = (string) $request->referencia;
        $detalle->save();

        $this->actualizarEncabezado($detalle);


        return response()->json(['estatus' => true, 'message' => 'Detalle fue creado con exito.!', 'errors' => []], 200);
    }

    public function edit(RequisicionC $detalle)
    {
        $req_c = RequisicionC::selectRaw("*, (FORMAT(FECHA_ENTREGA, 'yyyy-MM-dd')) FECHA")->where('RECNUM', $detalle->RECNUM)->first();
        return response()->json(['estatus' => true, 'message' => '', 'detalle' => $req_c, 'errors' => []], 200);
    }

    public function update(Request $request, RequisicionC $detalle)
    {
        $request->validate([
            'sugerido' => [
                'required',
                'in:S,N',
                function ($attribute, $value, $fail) use ($detalle) {

                    if ($value == 'S') {
                        $exists = RequisicionC::where('REQ_D', $detalle->REQ_D)
                            ->where('AUTORIZA1', 'S')
                            ->whereNot('RECNUM', $detalle->RECNUM)
                            ->exists();

                        if ($exists) {
                            $fail('Ya existe un registro sugerido para este detalle.');
                        }
                    }
                },
            ],
            'proveedor' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($detalle) {
                    $exists = RequisicionC::where('REQ_D', $detalle->REQ_D)
                        ->where('PRVEEDOR', $value)
                        ->whereNot('RECNUM', $detalle->RECNUM)
                        ->exists();

                    if ($exists) {
                        $fail('Ya existe un registro con este proveedor para esta requisición.');
                    }
                },
            ],
            'precio_unitario' => 'required',
            'proveedor_nombre' => [
                'required_if:proveedor,4',
                'max:255'
            ],
            'fecha_entrega' => 'required|date',
            'referencia' => 'required|string',
            'descripcion' => 'required|string|max:100',
        ]);

        $proveedor = DB::connection('sqlsrv-secondary')->table('PRVEEDOR')->where('NUMERO', $request->proveedor)->first();

        $refe = trim((string) $request->referencia);

        $detalle->PRVEEDOR = $request->proveedor;
        $detalle->PRVEEDOR_NOMBRE = $request->proveedor == 4 ? $request->proveedor_nombre : $proveedor->NOMBRE_COMPLETO;
        $detalle->PU = $request->precio_unitario;
        $detalle->COMENTARIOS = $request->descripcion;
        if ($detalle->encabezado->requisicion->ESTATUS != 'H') {
            $detalle->AUTORIZA1 = $request->sugerido;
        }
        $detalle->AUTORIZA2 = $request->sugerido;
        $detalle->FECHA_ENTREGA = $request->fecha_entrega;
        $detalle->REFERENCIA_PR = $refe;
        $detalle->save();

        $this->actualizarEncabezado($detalle);

        return response()->json(['estatus' => true, 'message' => 'Detalle fue creado con exito.!', 'errors' => []], 200);
    }

    public function delete(RequisicionC $detalle)
    {
        $detalle->delete();
        return response()->json(['estatus' => true, 'message' => 'Detalle fue eliminado con exito.!', 'errors' => []], 200);
    }

    private function actualizarEncabezado(RequisicionC $detalle)
    {
            $sugerido = RequisicionC::where(function($query) use ($detalle) {
                if ($detalle->encabezado->requisicion->ESTATUS != 'H') {
                    $query->where('AUTORIZA1', 'S');
                } else {
                    $query->where('AUTORIZA2', 'S');
                }
            })
            ->where('REQ_D', $detalle->REQ_D)
            ->first();

        if ($sugerido) {
            RequisicionD::where('NUMERO', $detalle->REQ_D)->update(['PRVEEDOR_AUT' => $detalle->PRVEEDOR]);
        } else {
            RequisicionD::where('NUMERO', $detalle->REQ_D)->update(['PRVEEDOR_AUT' => 0]);
        }
    }
}
