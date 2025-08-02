<?php

namespace App\Http\Controllers;

use App\Models\Feriado;
use Illuminate\Http\Request;

class FeriadoController extends Controller
{
    public function index()
    {
        $feriados = Feriado::paginate(15);
        return view('feriados.index')->with(['feriados' => $feriados]);
    }

    public function new()
    {
        return view('feriados.new');
    }

    public function store(Request $request)
    {
        $messages = array(
            'nombre.required' => 'Campo Nombre es Requerido',
            'nombre.max' => 'Campo Nombre tiene un maximo de 100 caracteres',
            'fecha.required' => 'Campo Fecha es Requerido',
        );

        $request->validate([
            'nombre' => ['required', 'max:100'],
            'fecha' => ['required'],
        ], $messages);

        $feriado = new Feriado();
        $feriado->nombre = $request->nombre;
        $feriado->fecha = $request->fecha;
        $feriado->save();

        return redirect()->route('feriados.edit', $feriado)->with(['status' => 'success', 'message' => 'El feriado fue creado correctamente!']);
    }

    public function edit(Feriado $feriado)
    {
        return view('feriados.edit')->with(['feriado' => $feriado]);
    }

    public function update(Request $request, Feriado $feriado)
    {
        $messages = array(
            'nombre.required' => 'Campo Nombre es Requerido',
            'nombre.max' => 'Campo Nombre tiene un maximo de 100 caracteres',
            'fecha.required' => 'Campo Fecha es Requerido',
        );

        $request->validate([
            'nombre' => ['required', 'max:100'],
            'fecha' => ['required'],
        ], $messages);

        $feriado->nombre = $request->nombre;
        $feriado->fecha = $request->fecha;
        $feriado->save();

        return redirect()->route('feriados.edit', $feriado)->with(['status' => 'success', 'message' => 'El feriado fue editado correctamente!']);
    }

    public function delete(Feriado $feriado)
    {
        $feriado->delete();
        return redirect()->route('feriados.index')->with(['status' => 'success', 'message' => 'El feriado fue eliminado correctamente!']);
    }
}
