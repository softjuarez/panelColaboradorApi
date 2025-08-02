<?php

namespace App\Http\Controllers;

use App\Models\BitacoraSolicitud;
use App\Models\Documento;
use App\Models\DocumentoDetalle;
use App\Models\SolicitudH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;

class DocumentoDetalleController extends Controller
{
    public function new(Documento $documento, $filtroDocumento)
    {
        return view('detalles.new')->with('documento', $documento)->with('filtroDocumento', $filtroDocumento);
    }

    public function store(Request $request, Documento $documento, $filtroDocumento)
    {
        $messages = array(
            'bien_servicio.required' => 'Campo Bien o Servicio es Requerido',
            'um.required' => 'Campo Unidad de Medida es Requerido',
            'um.max' => 'Campo Unidad de Medida tiene un maximo de 15 caracteres',
            'cantidad.required' => 'Campo Cantidad es Requerido',
            'cantidad.regex' => 'Campo Cantidad solo permite enteros o decimales',
            'precio_uni.required' => 'Campo Precio Unitario es Requerido',
            'precio_uni.regex' => 'Campo Precio Unitario solo permite enteros o decimales',
            'valor_impuestos.required' => 'Campo Valor Impuestos es Requerido',
            'valor_impuestos.regex' => 'Campo Valor Impuestos solo permite enteros o decimales',
            'descuento.required' => 'Campo Descuento es Requerido',
            'descuento.regex' => 'Campo Retencion solo permite enteros o decimales',
            'descripcion.required' => 'Campo Descripcion es Requerido',
            'descripcion.max' => 'Campo Descripcion tiene un maximo de 512 caracteres',
        );

        $request->validate([
            'bien_servicio' => ['required'],
            'um' => ['required', 'max:15'],
            'cantidad' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'precio_uni' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'valor_impuestos' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'descuento' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'descripcion' => ['required', 'max:512'],
        ], $messages);

        $solicitud = SolicitudH::find($documento->solicitud_id);
        $documentosH = DB::table('documentos')->where('solicitud_id', $solicitud->id)->whereNotIn('estatus', [4])->pluck('id');
        $totalTodosDetalles = DB::table('documento_detalles')->select(DB::raw('ISNULL(sum(valor_total), 0) as total'))->whereIn('id_documentos', $documentosH)->first();
        $totalActualDetalle = ((floatval($request->cantidad) * floatval($request->precio_uni)) + floatval($request->valor_impuestos)) - floatval($request->descuento);

        if ((floatval($totalTodosDetalles->total) + $totalActualDetalle) > $solicitud->valor) {
            $errorsBag = new MessageBag();
            $errorsBag->add('error', 'El total del documento, excede al total de la solicitud.');
            return Redirect::back()->withInput()->withErrors($errorsBag->all());
        }

        $linea = DB::select("
            select ISNULL(MAX(linea), 0) +1 linea from documento_detalles where id_documentos = $documento->id
        ");
        
        $detalle = new DocumentoDetalle();
        $detalle->id_documentos = $documento->id;
        $detalle->exento_sn = $request->exento == 'on' ? 'S' : 'N';
        $detalle->linea = $linea[0]->linea;
        $detalle->descripcion = $request->descripcion;
        $detalle->bien_servicio = $request->bien_servicio;
        $detalle->cantidad = $request->cantidad;
        $detalle->um = $request->um;
        $detalle->precio_uni = $request->precio_uni;
        $detalle->valor_total = ((floatval($request->cantidad) * floatval($request->precio_uni)) + floatval($request->valor_impuestos)) - floatval($request->descuento);
        $detalle->valor_descuento = $request->descuento;
        $detalle->valor_iva = $request->exento == 'on' ? 0.00 : ((floatval($request->cantidad) * floatval($request->precio_uni)) / 1.12) * 0.12;
        $detalle->valor_impuestos = $request->valor_impuestos;
        $detalle->save();

        $this->calcularEncabezado($documento);

        $this->generarBitacora('Detalles', 'Crear', "Se a creado el detalle con id $detalle->id que pertenece al documento con id $documento->id");

        return redirect()->route('documentos.edit', [$documento, $filtroDocumento])->with('success','Detalle Creado Correctamente!');
    }

    public function edit(Documento $documento, DocumentoDetalle $detalle, $filtroDocumento)
    {
        return view('detalles.edit')->with('documento', $documento)->with('detalle', $detalle)->with('filtroDocumento', $filtroDocumento);
    }
    
    public function update(Request $request, Documento $documento, DocumentoDetalle $detalle, $filtroDocumento)
    {
        $messages = array(
            'bien_servicio.required' => 'Campo Bien o Servicio es Requerido',
            'um.required' => 'Campo Unidad de Medida es Requerido',
            'um.max' => 'Campo Unidad de Medida tiene un maximo de 15 caracteres',
            'cantidad.required' => 'Campo Cantidad es Requerido',
            'cantidad.regex' => 'Campo Cantidad solo permite enteros o decimales',
            'precio_uni.required' => 'Campo Precio Unitario es Requerido',
            'precio_uni.regex' => 'Campo Precio Unitario solo permite enteros o decimales',
            'valor_impuestos.required' => 'Campo Valor Impuestos es Requerido',
            'valor_impuestos.regex' => 'Campo Valor Impuestos solo permite enteros o decimales',
            'descuento.required' => 'Campo Descuento es Requerido',
            'descuento.regex' => 'Campo Retencion solo permite enteros o decimales',
            'descripcion.required' => 'Campo Descripcion es Requerido',
            'descripcion.max' => 'Campo Descripcion tiene un maximo de 512 caracteres',
        );

        $request->validate([
            'bien_servicio' => ['required'],
            'um' => ['required', 'max:15'],
            'cantidad' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'precio_uni' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'valor_impuestos' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'descuento' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'descripcion' => ['required', 'max:512'],
        ], $messages);

        $solicitud = SolicitudH::find($documento->solicitud_id);
        $documentosH = DB::table('documentos')->where('solicitud_id', $solicitud->id)->whereNotIn('estatus', [4])->pluck('id');
        $totalTodosDetalles = DB::table('documento_detalles')->select(DB::raw('ISNULL(sum(valor_total), 0) as total'))->whereIn('id_documentos', $documentosH)->where('id', '<>', $detalle->id)->first();
        $totalActualDetalle = ((floatval($request->cantidad) * floatval($request->precio_uni)) + floatval($request->valor_impuestos)) - floatval($request->descuento);
        
        if ((floatval($totalTodosDetalles->total) + $totalActualDetalle) > $solicitud->valor) {
            $errorsBag = new MessageBag();
            $errorsBag->add('error', 'El total del documento, excede al total de la solicitud.');
            return Redirect::back()->withInput()->withErrors($errorsBag->all());
        }

        $detalle->descripcion = $request->descripcion;
        $detalle->bien_servicio = $request->bien_servicio;
        $detalle->cantidad = $request->cantidad;
        $detalle->um = $request->um;
        $detalle->precio_uni = $request->precio_uni;
        $detalle->valor_total = ((floatval($request->cantidad) * floatval($request->precio_uni)) + floatval($request->valor_impuestos)) - floatval($request->descuento);
        $detalle->valor_descuento = $request->descuento;
        $detalle->valor_iva = $request->exento == 'on' ? 0.00 : ((floatval($request->cantidad) * floatval($request->precio_uni)) / 1.12) * 0.12;
        $detalle->valor_impuestos = $request->valor_impuestos;
        $detalle->exento_sn = $request->exento == 'on' ? 'S' : 'N';
        $detalle->save();

        $this->generarBitacora('Detalles', 'Editar', "Se a editado el detalle con id $detalle->id que pertenece al documento con id $documento->id");

        $this->calcularEncabezado($documento);

        return redirect()->route('documentos.edit', [$documento, $filtroDocumento])->with('success','Detalle Editado Correctamente!');
    }
    
    public function delete(Documento $documento, DocumentoDetalle $detalle, $filtroDocumento)
    {
        $detalle->delete();
        $this->generarBitacora('Detalles', 'Eliminar', "Se a eliminado el detalle con id $detalle->id que pertenece al documento con id $documento->id");
        $this->calcularEncabezado($documento);
        return redirect()->route('documentos.edit', [$documento, $filtroDocumento])->with('success','Detalle Eliminado Correctamente!');
    }

    private function calcularEncabezado(Documento $documento)
    {
        $totales = DB::select("
            select sum(valor_total) total, sum(valor_iva) iva, sum(valor_impuestos) impuestos from documento_detalles where id_documentos = $documento->id
        ");

        $documento->valor_gran_total = $totales[0]->total;
        $documento->valor_iva = $totales[0]->iva;
        $documento->valor_impuestos = $totales[0]->impuestos;
        $documento->save();

        return true;
    }

    private function validarSolicitudFinalizada(Documento $documento, SolicitudH $solicitud)
    {
        $documentosH = DB::table('documentos')->where('solicitud_id', $solicitud->id)->pluck('id');
        $totalTodosDetalles = DB::table('documento_detalles')->select(DB::raw('ISNULL(sum(valor_total), 0) as total'))->whereIn('id_documentos', $documentosH)->first();
        if (floatval($totalTodosDetalles->total) == $solicitud->valor) {
            $solicitud->estado = 'C';
            $solicitud->save();
            $this->generarBitacora('Solicitudes', 'Editar', "Se a editado la solicitud con id $solicitud->id");
            $this->generarLineaDeTiempoSolicitud($solicitud, "Se cambio de estado la solicitud, paso a estado Finalizado, se completo el valor total.", 'Se cambio de estado automaticamente');
        }
    }

    private function generarLineaDeTiempoSolicitud(SolicitudH $solicitud, $razon, $accion)
    {
        $bitacora = new BitacoraSolicitud();
        $bitacora->usuario_id = auth()->user()->id;
        $bitacora->solicitud_id = $solicitud->id;
        $bitacora->razon = $razon;
        $bitacora->accion = $accion;
        $bitacora->save();
        return true;
    }
}
