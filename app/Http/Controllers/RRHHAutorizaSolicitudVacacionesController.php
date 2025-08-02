<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SolicitudVacaciones;
use App\Models\VacacionH;

class RRHHAutorizaSolicitudVacacionesController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudVacaciones::where('ESTATUS', 'F')->paginate(15);
        return view('rrhh_solicitudes_vacaciones.index')->with(['solicitudes' => $solicitudes]);
    }

    public function edit(SolicitudVacaciones $solicitud)
    {
        $detalles = DB::table('VACAC_D')->where('VACACION', $solicitud->DFRECNUM)->orderBy('FECHA_INICIO', 'ASC')->get();
        $solicitudWeb = VacacionH::where('vacacion', $solicitud->DFRECNUM)->first();
        return view('rrhh_solicitudes_vacaciones.edit')->with(['solicitud' => $solicitud, 'detalles' => $detalles, 'solicitud_web' => $solicitudWeb]);
    }

    public function verificar(SolicitudVacaciones $solicitud)
    {
        $solicitudWeb = VacacionH::where('vacacion', $solicitud->DFRECNUM)->first();
        $solicitudWeb->detalles()->where('estatus', '!=', 'R')->update(['vacaciones_d.estatus' => 'C']);

        $solicitudWeb->estatus = 'C';
        $solicitudWeb->usuario_verifica = auth()->user()->id;
        $solicitudWeb->fecha_verifica = date('Y-m-d H:i:s');
        $solicitudWeb->save();

        $solicitud->estatus = 'C';
        $solicitud->save();

        return redirect()->route('rrhh_solicitud_vacaciones.index')->with(['status' => 'success', 'message' => 'Solicitud verificada correctamente.']);

    }
}
