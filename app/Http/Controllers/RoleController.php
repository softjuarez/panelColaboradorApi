<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index($search = '')
    {
        $roles = Role::where('name', 'like', "%$search%")->paginate(15);

        return view('roles.index')
                ->with(['roles' => $roles, 'search' => $search]);
    }

    public function new()
    {
        $permissions = Permission::all();
        return view('roles.new')->with('permissions', $permissions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->type = $request->tipo == 'on' ? 'I' : 'E';
        $role->save();

        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $role->permissions()->attach($permission);
            }
        }

        return redirect()->route('roles.edit', $role)->with(['status' => 'success', 'message' => 'Role was successfully created!']);
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return view('roles.edit')
                ->with('role', $role)
                ->with('permissions', $permissions);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $role->name = $request->name;
        $role->type = $request->tipo == 'on' ? 'I' : 'E';
        $role->save();

        $role->permissions()->detach();
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $role->permissions()->attach($permission);
            }
        }

        return redirect()->route('roles.edit', $role)->with(['status' => 'success', 'message' => 'Role was successfully updated!']);
    }

    public function delete(Role $role)
    {
        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('roles.index')
            ->with(['status' => 'success', 'message' => 'Role was successfully deleted!']);
    }
}
