<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\DocumentoDetalle;
use App\Models\OrdenDeCompraH;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;

class ProveedorDocumentoController extends Controller
{
    public function index()
    {
        $documentos = Documento::whereIn('proveedor_id', auth()->user()->proveedores->pluck('NUMERO'))->orderBy('id', 'desc')->paginate(15);
        return view('proveedor_documentos.index')->with('documentos', $documentos);
    }

    public function new(OrdenDeCompraH $orden)
    {
        return view('proveedor_documentos.new')->with('orden', $orden);
    }

    public function store(Request $request, OrdenDeCompraH $orden)
    {
        $request->validate([
            'serie' => ['required', 'max:15'],
            'numero_docto' => ['required', 'max:15'],
            'uuid' => ['required', 'max:50', function ($attribute, $value, $fail) {
                $exists = Documento::where('uuid', $value)->where('estatus', '<>', 4)->exists();
                if ($exists) {
                    $fail('El UUID ya está en nuestros registros.');
                }
            }],
            'fecha_docto' => ['required']
        ]);

        $documento = new Documento();
        $documento->empresa_id = $orden->EMPRESA;
        $documento->ordcom_h = $orden->NUMERO;
        $documento->proveedor_id = $orden->PRVEEDOR;
        $documento->clasificacion = 'N';
        $documento->estatus = '1';
        $documento->serie = $request->serie;
        $documento->numero_docto = $request->numero_docto;
        $documento->uuid = $request->uuid;
        $documento->fecha_docto = $request->fecha_docto;
        $documento->moneda = $orden->MONEDA;
        $documento->save();

        return redirect()->route('documentos_proveedor.edit', $documento)->with(['status' => 'success', 'message' => 'Documento creado correctamente!']);
    }

    public function edit(Documento $documento)
    {
        return view('proveedor_documentos.edit')->with('documento', $documento);
    }

    public function update(Request $request, Documento $documento)
    {
        $request->validate([
            'serie' => ['required', 'max:15'],
            'numero_docto' => ['required', 'max:15'],
            'uuid' => ['required', 'max:50', function ($attribute, $value, $fail) use ($documento) {
                $exists = Documento::where('uuid', $value)->where('estatus', '<>', 4)->where('id', '<>', $documento->id)->exists();
                if ($exists) {
                    $fail('El UUID ya está en nuestros registros.');
                }
            }],
            'fecha_docto' => ['required'],
            'clasificacion' => ['required', 'in:N,A']
        ]);

        $documento->serie = $request->serie;
        $documento->numero_docto = $request->numero_docto;
        $documento->uuid = $request->uuid;
        $documento->fecha_docto = $request->fecha_docto;
        $documento->save();

        return redirect()->route('documentos_proveedor.edit', $documento)->with(['status' => 'success', 'message' => 'Documento actualizado correctamente!']);
    }

    public function solicitarRevision(Documento $documento)
    {
        if ($documento->detalles()->count() == 0) {
            return redirect()->route('documentos_proveedor.edit', $documento)->with(['status' => 'error', 'message' => 'El documento no tiene detalles asociados.']);
        }

        if (empty($documento->pdf)) {
            return redirect()->route('documentos_proveedor.edit', $documento)->with(['status' => 'error', 'message' => 'El documento debe tener un pdf agregado.']);
        }

        $documento->estatus = 2;
        $documento->save();

        return redirect()->route('documentos_proveedor.edit', $documento)->with(['status' => 'success', 'message' => 'Revisión solicitada correctamente!']);
    }

    public function adjuntarPdf(Request $request, Documento $documento)
    {
        $request->validate([
            'documento' => ['required', 'mimes:pdf'],
        ]);

        $url = $request->file('documento')->store('pdf_documentos');

        $documento->pdf = $url;
        $documento->save();

        return response()->json([
            'documento' =>  $documento,
            'url_descarga' => route('download.file', base64_encode($documento->pdf)),
            'errors' => [],
        ]);
    }

    public function eliminarPdf(Documento $documento)
    {
        Storage::delete($documento->pdf);
        $documento->pdf = null;
        $documento->save();

        return response()->json(['status' => 'success', 'message' => 'PDF eliminado correctamente.']);
    }

    public function adjuntarXml(Request $request, OrdenDeCompraH $orden)
    {
        $request->validate([
            'documento' => ['required', 'mimes:application/xml,xml'],
        ]);

        $url = $request->file('documento')->store('xml');

        $errors = $this->validateXmlData($url, $orden);

        if (count($errors) != 0) {
            Storage::delete($url);

            $errorsBag = new MessageBag();
            $errorsBag->merge($errors);
            return response()->json([
                'errors' => [$errors],
            ]);
        }

        $documento = new Documento();
        $documento->empresa_id = $orden->EMPRESA;
        $documento->ordcom_h = $orden->NUMERO;
        $documento->proveedor_id = $orden->PRVEEDOR;
        $documento->clasificacion = 'N';
        $documento->estatus = '1';
        $documento->xml = $url;
        $documento->moneda = $orden->MONEDA;
        $documento->save();

        $this->actualizarDocumentos($documento);
        return response()->json([
            'documento' =>  $documento,
            'errors' => [],
        ]);
    }

    public function validateXmlData($urlXml, OrdenDeCompraH $orden)
    {
        $errors = [];
        $ob = $this->getXMLObject($urlXml);

        $empresa = DB::table('EMPRESA')->where('NUMERO', $orden->EMPRESA)->first();
        $nitEmpresa = str_replace('-', '', $empresa->NIT);

        if (rtrim($nitEmpresa) != $ob->SAT->DTE->DatosEmision->Receptor->attributes()->IDReceptor) {
            array_push($errors, 'El nit de la empresa seleccionada no pertenece a este documento.');
            return $errors;
        }

        $proveedor = Proveedor::find($orden->PRVEEDOR);
        $nitProveedor = str_replace('-', '', $proveedor->N_I_T);

        if (rtrim($nitProveedor) != $ob->SAT->DTE->DatosEmision->Emisor->attributes()->NITEmisor) {
            array_push($errors, 'El nit de este proveedor no pertenece a este documento.');
            return $errors;
        }

        $moneda = DB::connection('sqlsrv-secondary')->table('MONEDA')->selectRaw("RTRIM(CODIGO_FEL) CODIGO_FEL")->whereRaw("RTRIM(CLAVE) = RTRIM('$orden->MONEDA')")->first();

        if ( $ob->SAT->DTE->DatosEmision->DatosGenerales->attributes()->CodigoMoneda != $moneda->CODIGO_FEL) {
            array_push($errors, 'La moneda del documento, no es la misma de la orden.');
        }

        $unique = DB::table('documentos')->where('uuid', $ob->SAT->DTE->Certificacion->NumeroAutorizacion)->where('estatus', '<>', 4)->pluck('id')->count();
        if ($unique != 0) {
            array_push($errors, 'Ya existe el registro Identificador');
            return $errors;
        }

        $validacionGranTotal = 0;
        $validacionMontoImpuesto = 0;
        foreach ($ob->SAT->DTE->DatosEmision->Items->Item as $item) {
            $cantidad = intval($item->Cantidad);
            $precioU = floatval($item->PrecioUnitario);
            $descuento = floatval($item->Descuento);
            $totalItem = floatval($item->Total);
            $total = $cantidad * $precioU - $descuento;

            if(number_format($total, 4, '.', '') != number_format($totalItem, 4, '.', '')){
                array_push($errors, 'El total del detalle numero ' . intval($item->attributes()->NumeroLinea) . ' no es correcto.');
            }
            $validacionGranTotal += $total;

            foreach ($item->Impuestos->Impuesto as $impuesto) {
                $montoImpuesto = floatval($impuesto->MontoImpuesto);
                $montoGravable = $total - $montoImpuesto;

                if (number_format($montoGravable, 4, '.', '') != number_format(floatval($impuesto->MontoGravable), 4, '.', '')) {
                    array_push($errors, 'El monto gravable, no es igual, al de su detalle.');
                }
                $validacionMontoImpuesto += $montoImpuesto;
            }
        }

        if (number_format($validacionGranTotal, 4, '.', '') != number_format(floatval($ob->SAT->DTE->DatosEmision->Totales->GranTotal), 4, '.', '')) {
            array_push($errors, 'El total del documento, no es igual, al total de la suma de sus detalles.');
        }

        $totalTodosDetalles = DocumentoDetalle::select(DB::raw('ISNULL(sum(valor_total), 0) as total'))->whereIn('documento_id', $orden->documentos->where('estatus', '!=', 4)->pluck('id'))->first();

        $totalActualDetalle = number_format($validacionGranTotal, 2, '.', '');

        if ((floatval($totalTodosDetalles->total) + $totalActualDetalle) > $orden->VLR_FOB) {
            array_push($errors, 'El total del documento, excede al total de la solicitud.');
        }

        $montoTotalImpuesto = 0;
        foreach ($ob->SAT->DTE->DatosEmision->Totales->TotalImpuestos->TotalImpuesto as $impuesto) {
            $montoTotalImpuesto += floatval($impuesto->attributes()->TotalMontoImpuesto);
        }

        if (number_format($validacionMontoImpuesto, 4, '.', '') != number_format(floatval($montoTotalImpuesto), 4, '.', '')) {
            array_push($errors, 'El total monto impuesto del documento, no es igual, al total del impuesto, de la suma de sus detalles.');
        }

        return $errors;
    }

    public function actualizarDocumentos(Documento $documento)
    {
        //$empresa = DB::table('EMPRESA')->where('NUMERO', $documento->EMPRESA)->first();


        $ob = $this->getXMLObject($documento->xml);
        $documento->serie = $ob->SAT->DTE->Certificacion->NumeroAutorizacion->attributes()->Serie;
        $documento->numero_docto = $ob->SAT->DTE->Certificacion->NumeroAutorizacion->attributes()->Numero;
        $documento->uuid = $ob->SAT->DTE->Certificacion->NumeroAutorizacion;
        $documento->fecha_docto = $ob->SAT->DTE->DatosEmision->DatosGenerales->attributes()->FechaHoraEmision;
        $documento->valor_gran_total = floatval($ob->SAT->DTE->DatosEmision->Totales->GranTotal);
        $documento->valor_retencion = 0; //round(((floatval($ob->SAT->DTE->DatosEmision->Totales->GranTotal) / 100) * floatval($empresa->PORC_RET_IVA)), 2);

        $totalIva = 0;
        $totalImpuestos = 0;
        foreach ($ob->SAT->DTE->DatosEmision->Totales->TotalImpuestos as $impuesto) {
            if($impuesto->TotalImpuesto->attributes()->NombreCorto == 'IVA'){
                $totalIva = floatval($impuesto->TotalImpuesto->attributes()->TotalMontoImpuesto);
            } else {
                $totalImpuestos += floatval($impuesto->TotalImpuesto->attributes()->TotalMontoImpuesto);
            }
        }

        $documento->valor_iva = $totalIva;
        $documento->valor_impuestos = $totalImpuestos;
        $documento->save();
        $this->generarDetallesDeDocumentos($documento, $ob->SAT->DTE->DatosEmision);
        return true;
    }

    public function generarDetallesDeDocumentos(Documento $documento, $detalles)
    {
        foreach ($detalles->Items->Item as $item) {
            $detalle = new DocumentoDetalle();
            $detalle->documento_id = $documento->id;
            $detalle->linea = intval($item->attributes()->NumeroLinea);
            $detalle->bien_servicio = $item->attributes()->BienOServicio;
            $detalle->descripcion = substr(rtrim($item->Descripcion), 0, 512);
            $detalle->cantidad = intval($item->Cantidad);
            $detalle->um = rtrim($item->UnidadMedida);
            $detalle->precio_uni = floatval($item->PrecioUnitario);
            $detalle->valor_total = floatval($item->Total);
            $detalle->valor_descuento = floatval($item->Descuento);

            $totalIva = 0;
            $totalImpuestos = 0;
            foreach ($item->Impuestos->Impuesto as $impuesto) {
                if($impuesto->NombreCorto == 'IVA'){
                    $totalIva = floatval($impuesto->MontoImpuesto);
                } else {
                    $totalImpuestos += floatval($impuesto->MontoImpuesto);
                }
            }

            $detalle->valor_iva = floatval($totalIva);
            $detalle->valor_impuestos = floatval($totalImpuestos);
            $detalle->save();
        }

        return true;
    }

    private function getXMLObject($urlXML)
    {
        $xml = new \DOMDocument();
        $xml->preserveWhiteSpace = true;
        $xml->load(storage_path("app/" . $urlXML));
        $xml->save('t.xml');
        $xmlfile = file_get_contents('t.xml');
        $parseObj = str_replace($xml->lastChild->prefix.':',"",$xmlfile);
        return new \SimpleXMLElement($parseObj);
    }
}
