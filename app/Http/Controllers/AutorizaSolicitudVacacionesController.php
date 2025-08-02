<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SolicitudVacaciones;
use App\Models\VacacionD;
use App\Models\VacacionH;
use Carbon\Carbon;

class AutorizaSolicitudVacacionesController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudVacaciones::where('ESTATUS', 'A')->orderBy('DFRECNUM', 'DESC')->paginate(15);
        return view('autoriza_solicitudes_vacaciones.index')->with(['solicitudes' => $solicitudes]);
    }

    public function edit(SolicitudVacaciones $solicitud)
    {
        $detalles = DB::table('VACAC_D')->where('VACACION', $solicitud->DFRECNUM)->orderBy('FECHA_INICIO', 'ASC')->get();
        $solicitudWeb = VacacionH::where('vacacion', $solicitud->DFRECNUM)->first();

        return view('autoriza_solicitudes_vacaciones.edit')->with(['solicitud' => $solicitud, 'detalles' => $detalles, 'solicitud_web' => $solicitudWeb]);
    }

    public function rechazar(SolicitudVacaciones $solicitud, $detalle)
    {
        DB::table('VACAC_D')->where('DFRECNUM', $detalle)->update(['TOTAL' => 0, 'TIEMPO' => 0]);
        return redirect()->route('autoriza_solicitud_vacaciones.edit', $solicitud)->with(['status' => 'success', 'message' => 'Fecha rechazada correctamente!']);
    }

    public function autorizaSolicitud(Request $request, SolicitudVacaciones $solicitud)
    {
        $request->validate([
            'motivo_autoriza' => [
                function ($attribute, $value, $fail) use ($solicitud) {
                    $hasZeroTotal = DB::table('VACAC_D')
                        ->where('VACACION', $solicitud->DFRECNUM)
                        ->where('TOTAL', 0)
                        ->exists();

                    if ($hasZeroTotal && empty($value)) {
                        $fail('El motivo de autorización es requerido cuando rechazas una fecha.');
                    }
                },
                'max:255'
            ],
        ]);

        $fechas = DB::table('VACAC_D')
            ->where('VACACION', $solicitud->DFRECNUM)
            ->where('TOTAL', 0)
            ->pluck('FECHA_INICIO')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();


        VacacionD::join('vacaciones_h', 'vacaciones_h.id', '=', 'vacaciones_d.vacaciones_h_id')
                    ->where('vacaciones_h.vacacion', $solicitud->DFRECNUM)
                    ->whereIn('vacaciones_d.fecha', $fechas)
                    ->update(['vacaciones_d.estatus' => 'R']);

        DB::table('VACAC_D')->where('VACACION', $solicitud->DFRECNUM)->where('TOTAL', 0)->delete();
        $solicitudWeb = VacacionH::where('vacacion', $solicitud->DFRECNUM)->first();

        $solicitudWeb->detalles()->where('estatus', '!=', 'R')->update(['vacaciones_d.estatus' => 'F']);


        $solicitudWeb->estatus = 'F';
        $solicitudWeb->razon_autoriza = $request->motivo_autoriza;
        $solicitudWeb->dias_otorgados = $solicitudWeb->detalles->where('estatus', 'F')->sum('valor');
        $solicitudWeb->usuario_autoriza = auth()->user()->id;
        $solicitudWeb->fecha_autoriza = date('Y-m-d H:i:s');
        $solicitudWeb->save();

        $solicitud->estatus = 'F';
        $solicitud->DIAS_OTORGADOS = $solicitudWeb->detalles->where('estatus', 'F')->sum('valor');
        $solicitud->save();

        return redirect()->route('autoriza_solicitud_vacaciones.index')->with(['status' => 'success', 'message' => 'Solicitud autorizada correctamente.']);
    }

    public function rechazaSolicitud(Request $request, SolicitudVacaciones $solicitud)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:255',
        ]);

        DB::table('VACAC_D')->where('VACACION', $solicitud->DFRECNUM)->delete();
        VacacionD::join('vacaciones_h', 'vacaciones_h.id', '=', 'vacaciones_d.vacaciones_h_id')
                    ->where('vacaciones_h.vacacion', $solicitud->DFRECNUM)
                    ->update(['vacaciones_d.estatus' => 'R']);

        $solicitudWeb = VacacionH::where('vacacion', $solicitud->DFRECNUM)->first();



        $solicitudWeb->estatus = 'R';
        $solicitudWeb->razon_rechazo = $request->motivo_rechazo;
        $solicitudWeb->save();

        $solicitud->delete();

        return redirect()->route('autoriza_solicitud_vacaciones.index')->with(['status' => 'success', 'message' => 'Solicitud rechazada correctamente.']);
    }
}
