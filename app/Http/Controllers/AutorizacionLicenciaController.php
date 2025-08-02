<?php

namespace App\Http\Controllers;

use App\Models\Licencia;
use Illuminate\Http\Request;

class AutorizacionLicenciaController extends Controller
{

    public function index($search = '')
    {
        $licencias = Licencia::join('ficha', 'ficha.NUMERO', '=', 'licencias.ficha_crea')
                            ->where('licencias.estatus', 'B')
                            ->where('ficha.NOMBRE', 'LIKE', '%'.$search.'%')
                            ->orderBy('created_at', 'desc')
                            ->paginate(15);

        return view('autoriza_licencias.index')->with(['licencias' => $licencias, 'search' => $search]);
    }

    public function edit(Licencia $licencia)
    {
        return view('autoriza_licencias.edit')->with(['licencia' => $licencia]);
    }

    public function autorizar(Licencia $licencia)
    {
        $licencia->estatus = 'C';
        $licencia->usuario_atendio = auth()->user()->id;
        $licencia->fecha_atendio = date('Y-m-d');
        $licencia->save();

        return redirect()->route('autoriza_licencias.index')->with(['status' => 'success', 'message' => 'Licencia autorizada correctamente.']);
    }

    public function rechazar(Request $request, Licencia $licencia)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:255',
        ]);

        $licencia->estatus = 'A';
        $licencia->razon_rechazo = $request->motivo_rechazo;
        $licencia->usuario_atendio = auth()->user()->id;
        $licencia->fecha_atendio = date('Y-m-d');
        $licencia->save();

        return redirect()->route('autoriza_licencias.index')->with(['status' => 'success', 'message' => 'Licencia rechazada correctamente.']);
    }
}
