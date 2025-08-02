<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;

class ReporteFichaDeResponsabilidadController extends Controller
{
    public function launcher()
    {
        $sedes = DB::connection('sqlsrv')->table('sucursal')->get();
        return view('lanzadores.responsabilidad')->with(['sedes' => $sedes]);
    }

    public function generar($fecha_inicio, $fecha_fin, $sede)
    {
       //que baje la observacion
        $pFI = Carbon::parse($fecha_inicio)->format('Ymd');
        $pFF = Carbon::parse($fecha_fin)->format('Ymd');

        $sede = ($sede == 0) ? '' : $sede;

        $data = DB::select(
            'exec [ACT_FIJO_UDV].[dbo].[HOJA_RESP_ACTIVOS] ?, ?, ?, ?, ?',
            [
                auth()->user()->fichaActiva(),
                1,
                $pFI,
                $pFF,
                $sede
            ]
        );

        $empresa = DB::connection('sqlsrv-secondary')->table('EMPRESA')->where('NUMERO', 1)->first();
        $ficha = Ficha::find(auth()->user()->fichaActiva());



        view()->share(['data' => $data, 'ficha' => $ficha, 'parametros' => ['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin, 'sede' => $sede, 'empresa' => $empresa]]);
        $pdf = PDF::loadView('reportes.responsabilidad')->setPaper('a4', 'portrait');
        return $pdf->stream('ficha de responsabilidad.pdf');
    }
}
