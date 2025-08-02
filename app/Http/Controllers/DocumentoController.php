<?php

namespace App\Http\Controllers;

use App\Models\BitacoraDocumentos;
use App\Models\BitacoraSolicitud;
use App\Models\Documento;
use App\Models\DocumentoDetalle;
use App\Models\DocumentoOrden;
use App\Models\Empresa;
use App\Models\Proveedor;
use App\Models\SolicitudH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;

class DocumentoController extends Controller
{
    public function index($estado = 2, $search = '')
    {
        $query = Documento::orderBy('id', 'desc')->where('documentos.estatus', '<>', '1')->whereRaw("documentos.estatus = IIF($estado = 0, documentos.estatus, $estado)");

        if ($search) {
            $query->join(Proveedor::getTableName(), function($join) {
                    $join->on('documentos.proveedor_id', '=', 'NUMERO');
                })
                ->where('PRVEEDOR.NOMBRE_COMPLETO', 'like', '%' . $search . '%');
        }

        return view('documentos.index')->with(['documentos' => $query->paginate(15), 'search' => $search, 'estado' => $estado]);
    }

    public function edit(Documento $documento)
    {
        return view('documentos.edit')->with('documento', $documento);
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
            'fecha_docto' => ['required']
        ]);

        $documento->clasificacion = $request->clasificacion;
        $documento->serie = $request->serie;
        $documento->numero_docto = $request->numero_docto;
        $documento->uuid = $request->uuid;
        $documento->fecha_docto = $request->fecha_docto;
        $documento->save();

        return redirect()->route('documentos.edit', $documento)->with('success','Documento Editado Correctamente!');
    }

    public function calcularFechaPago(Documento $documento)
    {
        if ($documento->clasificacion == '') {
            $errorsBag = new MessageBag();
            $errorsBag->add('error', 'Para el calculo de fechas tienes que asignar una clasificacion!.');
            return redirect()->route('documentos.edit', $documento)->withErrors($errorsBag);
        }

        $fechaDocumento = $this->obtenerFechaPagoDeUnDocumento($documento);
        $documento->fecha_pago = $fechaDocumento;
        $documento->fecha_vence = $fechaDocumento;
        $documento->save();

        return redirect()->route('documentos.edit', $documento)->with(['status' => 'success', 'message' => 'Fechas de pago calculadas correctamente!']);
    }

    public function obtenerFechaPago(Documento $documento)
    {
        $fechaDocumento = $this->obtenerFechaPagoDeUnDocumento($documento);
        return response()->json(['response' => $fechaDocumento], 200);
    }

    public function autorizar(Documento $documento)
    {
        if ($documento->fecha_vence == null) {
            return redirect()->route('documentos.edit', $documento)->with(['status' => 'error', 'message' => 'Fechas de pago debe ser calculada!']);
        }

        $documento->estatus = 3;
        $documento->save();
        return redirect()->route('documentos.edit', $documento)->with(['status' => 'success', 'message' => 'Documento autorizado correctamente!']);
    }

    public function rechazar(Request $request, Documento $documento)
    {
        $request->validate([
            'motivo_rechazo' => ['required', 'min:10'],
        ]);

        $documento->rechazo = $request->motivo_rechazo;
        $documento->estatus = 4;
        $documento->save();

        return redirect()->route('documentos.edit', $documento)->with(['status' => 'success', 'message' => 'Documento rechazado correctamente!']);
    }

    public function adjuntarPdf(Request $request, Documento $documento)
    {
        $request->validate([
            'documento' => ['required', 'file', 'mimes:pdf'],
            'exento' => ['nullable', 'in:S,N'],
        ]);

        $url = $request->file('documento')->store('pdf_documentos');

        if ($request->exento == 'S') {
            $documento->path_exento = $url;
        } else {
            $documento->path_retencion = $url;
        }
        $documento->save();

        return response()->json([
            'documento' =>  $documento,
            'archivos' => [
                [
                    'cargado' => $documento->path_retencion != null,
                    'nombre' => 'Archivo Retención',
                    'url_descarga' => route('download.file', base64_encode($documento->path_retencion)),
                    'tipo' => 'retencion',
                ],
                [
                    'cargado' => $documento->path_exento != null,
                    'nombre' => 'Archivo Exento',
                    'url_descarga' => route('download.file', base64_encode($documento->path_exento)),
                    'tipo' => 'exento',
                ]
            ],
            'errors' => [],
        ]);
    }

    public function eliminarPdf(Documento $documento, $tipo)
    {
        if ($tipo == 1) {
            if ($documento->path_retencion) {
                Storage::delete($documento->path_retencion);
                $documento->path_retencion = null;
            }
        } elseif ($tipo == 2) {
            if ($documento->path_exento) {
                Storage::delete($documento->path_exento);
                $documento->path_exento = null;
            }
        }

        $documento->save();

        return response()->json([
            'documento' =>  $documento,
            'archivos' => [
                [
                    'cargado' => $documento->path_retencion != null,
                    'nombre' => 'Archivo Retención',
                    'url_descarga' => route('download.file', base64_encode($documento->path_retencion)),
                    'tipo' => 'retencion',
                ],
                [
                    'cargado' => $documento->path_exento != null,
                    'nombre' => 'Archivo Exento',
                    'url_descarga' => route('download.file', base64_encode($documento->path_exento)),
                    'tipo' => 'exento',
                ]
            ],
            'errors' => [],
        ]);
    }

    private function obtenerFechaPagoDeUnDocumento(Documento $documento)
    {
        $subMonths = $documento->created_at->subMonth(3)->format('Ymd');
        $addMonths = $documento->created_at->addMonth(3)->format('Ymd');

        $proveedor = Proveedor::find($documento->proveedor_id);
        $fecha = '';
        if ($documento->clasificacion == 'N'){
            $fecha = $documento->created_at->addDays($proveedor->DIAS_CREDITO == '' ? 0 : $proveedor->DIAS_CREDITO)->format('Ymd');
        }

        $fechas = DB::select("
            SET LANGUAGE Spanish;
            SELECT TOP 1 * FROM (
                SELECT
                    TOP (DATEDIFF(DAY, '$subMonths', '$addMonths') + 1)
                    Date = DATEADD(DAY, ROW_NUMBER() OVER(ORDER BY a.object_id) - 1, '$subMonths'),
                    Day = datename(weekday, DATEADD(DAY, ROW_NUMBER() OVER(ORDER BY a.object_id) - 1, '$subMonths'))
                FROM sys.all_objects a
                    CROSS JOIN sys.all_objects b
            ) X
            WHERE Day = (SELECT TOP 1 dia_pago FROM configuraciones)
            AND Date NOT IN (SELECT fecha FROM feriados)
            AND Date >= '$fecha'
        ");

        return date('Y-m-d', strtotime($fechas[0]->Date));
    }
}
