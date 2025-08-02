<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentoDetalleRequest;
use App\Models\Documento;
use App\Models\DocumentoDetalle;
use Illuminate\Http\Request;

class ProveedorDocumentoDetalleController extends Controller
{
    public function index(Documento $documento)
    {
        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $documento->detalles, 'errors' => []], 200);
    }

    public function store(DocumentoDetalleRequest $request, Documento $documento)
    {
        /*$request->validate([
            'bien_servicio' => ['required'],
            'unidad_medida' => ['required', 'max:15'],
            'cantidad' => ['required', 'numeric' ],
            'precio_unitario' => ['required', 'numeric'],
            'valor_impuestos' => ['required', 'numeric'],
            'descuento' => ['required', 'numeric'],
            'descripcion' => ['required', 'max:512'],
        ]);*/

        $detalle = new DocumentoDetalle();
        $detalle->documento_id = $documento->id;
        $detalle->exento_sn = $request->exento;
        $detalle->linea = DocumentoDetalle::where('documento_id', $documento->id)->max('linea') + 1;
        $detalle->descripcion = $request->descripcion;
        $detalle->bien_servicio = $request->bien_servicio;
        $detalle->cantidad = $request->cantidad;
        $detalle->um = $request->unidad_medida;
        $detalle->precio_uni = $request->precio_unitario;
        $detalle->valor_total = ((floatval($request->cantidad) * floatval($request->precio_unitario)) + floatval($request->valor_impuestos)) - floatval($request->descuento);
        $detalle->valor_descuento = $request->descuento;
        $detalle->valor_iva = $request->exento == 'S' ? 0.00 : ((floatval($request->cantidad) * floatval($request->precio_unitario)) / 1.12) * 0.12;
        $detalle->valor_impuestos = $request->valor_impuestos;
        $detalle->save();

        $this->actualizarDocumento($documento);

        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $documento->detalles, 'errors' => []], 200);
    }

    public function edit(DocumentoDetalle $detalle)
    {
        return response()->json(['estatus' => true, 'message' => '', 'detalle' => $detalle, 'errors' => []], 200);
    }

    public function update(DocumentoDetalleRequest $request, DocumentoDetalle $detalle)
    {
        /*$request->validate([
            'bien_servicio' => ['required'],
            'unidad_medida' => ['required', 'max:15'],
            'cantidad' => ['required', 'numeric'],
            'precio_unitario' => ['required', 'numeric'],
            'valor_impuestos' => ['required', 'numeric'],
            'descuento' => ['required', 'numeric'],
            'descripcion' => ['required', 'max:512'],
        ]);*/

        $detalle->exento_sn = $request->exento;
        $detalle->descripcion = $request->descripcion;
        $detalle->bien_servicio = $request->bien_servicio;
        $detalle->cantidad = $request->cantidad;
        $detalle->um = $request->unidad_medida;
        $detalle->precio_uni = $request->precio_unitario;
        $detalle->valor_total = round(((floatval($request->cantidad) * floatval($request->precio_unitario)) + floatval($request->valor_impuestos)) - floatval($request->descuento), 2);
        $detalle->valor_descuento = $request->descuento;
        $detalle->valor_iva = $request->exento == 'S' ? 0.00 : round(((floatval($request->cantidad) * floatval($request->precio_unitario)) / 1.12) * 0.12, 2);
        $detalle->valor_impuestos = $request->valor_impuestos;
        $detalle->save();

        $this->actualizarDocumento($detalle->documento);

        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $detalle->documento->detalles, 'errors' => []], 200);
    }

    public function delete(DocumentoDetalle $detalle)
    {
        $detalle->delete();
        $this->actualizarDocumento($detalle->documento);
        return response()->json(['estatus' => true, 'message' => '', 'detalles' => $detalle->documento->detalles, 'errors' => []], 200);
    }

    private function actualizarDocumento(Documento $documento)
    {
        $documento->valor_gran_total = $documento->detalles->sum('valor_total');
        $documento->valor_iva = $documento->detalles->sum('valor_iva');
        $documento->valor_impuestos = $documento->detalles->sum('valor_impuestos');
        $documento->save();
    }
}
