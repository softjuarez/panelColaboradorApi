<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organigrama;

class VisualizadorOrganigramaController extends Controller
{
    public function index()
    {
        $organigramas = Organigrama::paginate(15);
        return view('visualizador_organigramas.index')->with(['organigramas' => $organigramas]);
    }

    public function show(Organigrama $organigrama)
    {
        return view('visualizador_organigramas.show')->with(['organigrama' => $organigrama]);
    }
}
