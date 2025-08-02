<?php

namespace App\Http\Controllers;

use App\Models\ConexionNodo;
use App\Models\Nodo;
use App\Models\Organigrama;
use App\Rules\ValidarJerarquiaNodo;
use Illuminate\Http\Request;

class NodoController extends Controller
{
    public function index(Organigrama $organigrama)
    {
        $nodos = Nodo::where('organigrama_id', $organigrama->id)
                ->get()
                ->map(function ($node) {
                    $propiedades = json_decode($node->propiedades);

                    return array_merge(
                        $node->toArray(),
                        [
                            'color' => $propiedades->Color ?? null,
                            'icon' => $propiedades->Icon ?? null,
                            'x_pos' => $propiedades->PosicionX ?? 0,
                            'y_pos' => $propiedades->PosicionY ?? 0
                        ]
                    );
                });
        return response()->json(['estatus' => true, 'nodos' => $nodos], 200);
    }

    public function store(Request $request, Organigrama $organigrama)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'required|in:D,R',
            'color' => 'required|string|max:7',
            'icon' => 'nullable|string|max:50'
        ]);

        $node = new Nodo();
        $node->organigrama_id = $organigrama->id;
        $node->titulo = $request->title;
        $node->subtitulo = $request->subtitle;
        $node->tipo = $request->type;
        $node->propiedades = json_encode([
            'Color' => $request->color,
            'Icon' => $request->icon,
            'Template' => 1,
            'PosicionX' => 0,
            'PosicionY' => 0,
        ]);

        $node->save();

        return response()->json([
            'id' => $node->id,
            'titulo' => $node->titulo,
            'subtitulo' => $node->subtitulo,
            'tipo' => $node->tipo,
            'color' => json_decode($node->propiedades)->Color,
            'icon' => json_decode($node->propiedades)->Icon,
            'x_pos' => json_decode($node->propiedades)->PosicionX,
            'y_pos' => json_decode($node->propiedades)->PosicionY
        ]);
    }

    public function update(Request $request, Nodo $nodo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => [
                'required',
                'in:D,R',
                new ValidarJerarquiaNodo($nodo)
            ],
            'color' => 'required|string|max:7',
            'icon' => 'nullable|string|max:50'
        ]);

        $nodo->titulo = $request->title;
        $nodo->subtitulo = $request->subtitle;
        $nodo->tipo = $request->type;
        $propiedades = $nodo->propiedades ? json_decode($nodo->propiedades) : new \stdClass();
        $propiedades->Color = $request->color;
        $propiedades->Icon = $request->icon;
        $nodo->propiedades = json_encode($propiedades);

        $nodo->save();

        return response()->json([
            'id' => $nodo->id,
            'titulo' => $nodo->titulo,
            'subtitulo' => $nodo->subtitulo,
            'tipo' => $nodo->tipo,
            'color' => json_decode($nodo->propiedades)->Color,
            'icon' => json_decode($nodo->propiedades)->Icon
        ]);
    }

    public function delete(Nodo $nodo)
    {
        ConexionNodo::where('nodo_hijo_id', $nodo->id)->delete();
        ConexionNodo::where('nodo_padre_id', $nodo->id)->delete();
        $nodo->delete();

        return response()->json(['message' => 'Nodo eliminado.'], 200);
    }

    public function updatePosition(Request $request, Nodo $nodo)
    {
        $request->validate([
            'x' => 'required|numeric',
            'y' => 'required|numeric',
        ]);

        $propiedades = $nodo->propiedades ? json_decode($nodo->propiedades) : new \stdClass();
        $propiedades->PosicionX = $request->x;
        $propiedades->PosicionY = $request->y;

        $nodo->propiedades = json_encode($propiedades);
        $nodo->save();

        return response()->json(['message' => 'Posición actualizada'], 200);
    }
}
