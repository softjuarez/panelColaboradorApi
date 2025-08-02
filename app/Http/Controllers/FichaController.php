<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use App\Models\User;
use App\Models\TipoAdjunto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class FichaController extends Controller
{
    public function index($estado = 1, $asignacion = 1, $search = '')
    {
        $query = Ficha::where('NOMBRE', 'LIKE', '%'.$search.'%')
                    ->where('ESTATUS', $estado == 1 ? 'A' : 'B');

        if ($asignacion == 1) {
            $query->has('usuarios', '>', 0);
        } else {
            $query->doesntHave('usuarios');
        }

        $fichas = $query->paginate(10);
        $tipo_adjuntos = TipoAdjunto::all();

        return view('fichas.index')->with(['fichas' => $fichas, 'search' => $search, 'estado' => $estado, 'asignacion' => $asignacion, 'tipo_adjuntos' => $tipo_adjuntos]);
    }

    public function edit(Ficha $ficha)
    {
        $usuarios = User::all();
        return view('fichas.edit', ['ficha' => $ficha, 'usuarios' => $usuarios]);
    }

    public function update(Request $request, Ficha $ficha)
    {
        $request->validate(
            [
                'usuarios' => 'nullable|array',
                'usuarios.*' => 'integer|exists:users,id',
                'referencia' => [
                    'nullable',
                    'integer',
                    'exists:users,id',
                    'required_with:usuarios',
                    function ($attribute, $value, $fail) use ($request) {
                        if (!in_array($value, $request->input('usuarios', [])) && count($request->input('usuarios', [])) > 0) {
                            $fail('El elemento destacado debe estar entre las opciones seleccionadas.');
                        }
                    },
                    function ($attribute, $value, $fail) use ($request, $ficha) {
                        $existingFicha = DB::table('ficha_usuario')
                            ->where('usuario_id', $value)
                            ->where('referencia', 's')
                            ->whereNot('ficha_id', $ficha->NUMERO)
                            ->first();

                        if ($existingFicha && count($request->input('usuarios', [])) > 0) {
                            $fail('El usuario ya es referencia de otra ficha.');
                        }
                    }
                ],
            ]
        );

        $usuarios = $request->input('usuarios', []);
        $usuarioReferenciaId = $request->input('referencia');
        $usuariosConReferencia = [];

        foreach ($usuarios as $usuarioId) {
            $referencia = ($usuarioId == $usuarioReferenciaId) ? 's' : 'n';
            $usuariosConReferencia[$usuarioId] = ['referencia' => $referencia];
        }

        $ficha->usuarios()->sync($usuariosConReferencia);
        return redirect()->route('fichas.edit', $ficha)->with(['status' => 'success', 'message' => 'Ficha was successfully updated!']);
    }

    public function asignarCreandoUsuario(Request $request, Ficha $ficha)
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&\.]/'],
        ]);

        $user = new User();
        $user->name = $ficha->NOMBRE;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $ficha->usuarios()->attach($user->id, ['referencia' => 's']);

        return redirect()->route('fichas.edit', $ficha)->with(['status' => 'success', 'message' => 'Ficha was successfully updated!']);
    }

    public function listado()
    {
        $fichas = Ficha::all();
        return response()->json($fichas);
    }
}
