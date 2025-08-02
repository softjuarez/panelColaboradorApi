<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index($search = '')
    {
        $permissions = Permission::where('name', 'like', "%$search%")->paginate(15);

        return view('permissions.index')
                ->with(['permissions' => $permissions, 'search' => $search]);
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit')->with('permission', $permission);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:255'],
        ]);

        $permission->name = $request->name;
        $permission->description = $request->description;
        $permission->save();

        return redirect()->route('permissions.edit', $permission)->with(['status' => 'success', 'message' => 'Permission was successfully updated!']);
    }
}
