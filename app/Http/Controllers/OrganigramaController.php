<?php

namespace App\Http\Controllers;

use App\Models\Organigrama;
use Illuminate\Http\Request;

class OrganigramaController extends Controller
{
    public function index()
    {
        $organigramas = Organigrama::paginate(15);
        return view('organigramas.index')->with(['organigramas' => $organigramas]);
    }

    public function new()
    {
        return view('organigramas.new');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $organigrama = new Organigrama();
        $organigrama->nombre = $request->nombre;
        $organigrama->user_id = auth()->user()->id;
        $organigrama->save();

        return redirect()->route('organigramas.edit', $organigrama)->with(['status' => 'success', 'message' => 'Organigrama was successfully created!']);
    }

    public function edit(Organigrama $organigrama)
    {
        return view('organigramas.edit')->with(['organigrama' => $organigrama]);
    }
}
