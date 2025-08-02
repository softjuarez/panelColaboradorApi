<?php

namespace App\Http\Controllers;

use App\Models\Gestor;
use App\Models\User;
use Illuminate\Http\Request;

class GestorController extends Controller
{
    public function index()
    {
        $gestores = Gestor::paginate(15);
        return view('gestores.index')->with(['gestores' => $gestores]);
    }

    public function new()
    {
        $users = User::leftJoin('gestores', 'users.id', '=', 'gestores.user_id')
                    ->whereNull('gestores.user_id')
                    ->select('users.*')
                    ->get();

        return view('gestores.new')->with(['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|integer'
        ]);

        $gestor = new Gestor();
        $gestor->user_id = $request->usuario;
        $gestor->save();

        return redirect()->route('gestores.edit', $gestor)->with(['status' => 'success', 'message' => 'Gestor Creado Correctamente!']);
    }

    public function edit(Gestor $gestor)
    {
        $users = User::all();
        return view('gestores.edit')->with(['gestor' => $gestor, 'users' => $users]);
    }

    public function update(Request $request, Gestor $gestor)
    {
        $gestor->estatus = $request->estado == 'on' ? 'A' : 'B';
        $gestor->save();

        return redirect()->route('gestores.edit', $gestor)->with(['status' => 'success', 'message' => 'Gestor Actualizado Correctamente!']);
    }
}
