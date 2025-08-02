<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\ProveedorUsuario;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsuarioExternoController extends Controller
{
    public function index($search = '')
    {
        $users = User::where('name', 'like', "%$search%")->where('type', 'E')->paginate(15);
        return view('externos.index')->with(['users' => $users, 'search' => $search]);
    }

    public function new()
    {
        $roles = Role::where('type', 'E')->get();
        $proveedores = Proveedor::all();

        return view('externos.new')->with(['roles' => $roles, 'proveedores' => $proveedores]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&\.]/']
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->type = 'E';
        $user->password = Hash::make($request->password);
        $user->save();

        $user->roles()->attach($request->roles);
        $user->proveedores()->attach($request->proveedores);

        return redirect()->route('externos.edit', $user)->with(['status' => 'success', 'message' => 'User was successfully created!']);
    }

    public function edit(User $user)
    {
        $roles = Role::where('type', 'E')->get();
        $proveedores = Proveedor::all();

        return view('externos.edit')->with(['user' => $user, 'roles' => $roles, 'proveedores' => $proveedores]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;


        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::exists($user->foto)) {
                Storage::delete($user->foto);
            }

            $path = $request->file('foto')->store('public/perfiles');
            $user->foto = Storage::url($path);
        }


        $user->save();

        $user->roles()->detach();
        $user->roles()->attach($request->roles);

        $user->proveedores()->detach();
        $user->proveedores()->attach($request->proveedores);


        return redirect()->route('externos.edit', $user)->with(['status' => 'success', 'message' => 'User was successfully updated!']);
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&\.]/']
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('externos.edit', $user)
                ->with(['status' => 'success', 'message' => 'Password was successfully updated!']);
    }

    public function delete(User $user)
    {
        $user->roles()->detach();

        $user->delete();
        return redirect()->route('externos.index')->with(['status' => 'success', 'message' => 'User was successfully deleted!']);
    }
}
