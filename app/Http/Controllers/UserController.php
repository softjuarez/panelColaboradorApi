<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Receta;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index($search = '')
    {
        $users = User::where('name', 'like', "%$search%")->paginate(15);
        return view('users.index')->with(['users' => $users, 'search' => $search]);
    }

    public function new()
    {
        $roles = Role::all();
        $users = User::all();

        return view('users.new')
                ->with(['roles' => $roles, 'users' => $users]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&\.]/'],
            'jefe_inmediato' => ['required', 'integer']
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->jefe_id = $request->jefe_inmediato;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->roles()->attach($request->roles);
        return redirect()->route('users.edit', $user)->with(['status' => 'success', 'message' => 'User was successfully created!']);
    }
    
    public function edit(User $user)
    {
        $roles = Role::all();
        $users = User::all();

        return view('users.edit')
                ->with(['user' => $user, 'roles' => $roles, 'users' => $users]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'jefe_inmediato' => ['required', 'integer'],
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->jefe_id = $request->jefe_inmediato;


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
        

        return redirect()->route('users.edit', $user)
                ->with(['status' => 'success', 'message' => 'User was successfully updated!']);
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&\.]/']
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.edit', $user)
                ->with(['status' => 'success', 'message' => 'Password was successfully updated!']);
    }

    public function delete(User $user)
    {
        $user->roles()->detach();
        
        $user->delete();
        return redirect()->route('users.index')
            ->with(['status' => 'success', 'message' => 'User was successfully deleted!']);
    }
}
