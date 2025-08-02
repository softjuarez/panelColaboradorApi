<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $configuracion = DB::table('configuraciones')->first();
        $users = User::all();
        return view('configuraciones.index')->with(['configuracion' => $configuracion, 'users' => $users]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'destino_requisicion' => 'required',
            'notificar_solicitudes' => 'nullable',
            'dias_resguardo_semana_santa' => 'required',
            'dias_resguardo_fin_anio' => 'required',
            'dia_pago' => 'required',
        ]);

        DB::table('configuraciones')
            ->update([
                'destino_requisicion' => $request->destino_requisicion,
                'notificar_solicitudes' => $request->notificar_solicitudes,
                'dias_resguardo_semana_santa' => $request->dias_resguardo_semana_santa,
                'dias_resguardo_fin_anio' => $request->dias_resguardo_fin_anio,
                'dia_pago' => $request->dia_pago,
                'updated_at' => now()
            ]);

        return redirect()->route('configuraciones.index')->with(['status' => 'success', 'message' => 'Configuracion actualizada correctamente!']);
    }
}
