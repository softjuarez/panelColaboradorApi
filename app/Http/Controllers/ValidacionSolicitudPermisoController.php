<?php

namespace App\Http\Controllers;

use App\Models\SolicitudPermisos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ValidacionSolicitudPermisoController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudPermisos::where('ESTATUS', 'C')->paginate(15);
        return view('validacion_solicitud_permisos.index')->with(['solicitudes' => $solicitudes]);
    }

    public function edit(SolicitudPermisos $solicitud)
    {
        return view('validacion_solicitud_permisos.edit')->with(['solicitud' => $solicitud]);
    }

    public function verificar(SolicitudPermisos $solicitud)
    {
        $solicitud->estatus = 'D';
        $solicitud->save();

        return redirect()->route('validacion_solicitud_permisos.index')->with(['status' => 'success', 'message' => 'Solicitud verificada correctamente.']);
    }
}
