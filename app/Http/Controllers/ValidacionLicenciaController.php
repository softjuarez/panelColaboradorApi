<?php

namespace App\Http\Controllers;

use App\Mail\LicenciaAceptada;
use App\Mail\LicenciaRechazada;
use App\Models\Licencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ValidacionLicenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($search = '')
    {
        $licencias = Licencia::join('ficha', 'ficha.NUMERO', '=', 'licencias.ficha_crea')
                            ->where('licencias.estatus', 'C')
                            ->where('ficha.NOMBRE', 'LIKE', '%'.$search.'%')
                            ->orderBy('created_at', 'desc')
                            ->paginate(15);

        return view('validar_licencias.index')->with(['licencias' => $licencias, 'search' => $search]);
    }

    public function edit(Licencia $licencia)
    {
        return view('validar_licencias.edit')->with(['licencia' => $licencia]);
    }

    public function autorizar(Licencia $licencia)
    {
        $licencia->estatus = 'D';
        $licencia->save();

        try {
            Mail::to($licencia->usuario->email)->send(new LicenciaAceptada($licencia));
        } catch (\Exception $e) {
            Log::error("Error al enviar correo a {$licencia->usuario->email}: " . $e->getMessage());
        }

        return redirect()->route('validar_licencias.index')->with(['status' => 'success', 'message' => 'Licencia autorizada correctamente.']);
    }

    public function rechazar(Request $request, Licencia $licencia)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:255',
        ]);

        $licencia->estatus = 'B';
        $licencia->razon_rechazo = $request->motivo_rechazo;
        $licencia->save();

        try {
            Mail::to($licencia->usuario->email)->send(new LicenciaRechazada($licencia));
        } catch (\Exception $e) {
            Log::error("Error al enviar correo a {$licencia->usuario->email}: " . $e->getMessage());
        }


        return redirect()->route('validar_licencias.index')->with(['status' => 'success', 'message' => 'Licencia rechazada correctamente.']);
    }
}
