<?php

namespace App\Http\Controllers\Permissions;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    //
    public function index()
    {
        $permissions = Permission::get();
        $permission = new Permission;
        return view('permissions.permission.index', compact('permissions', 'permission'));
    }

    public function store()
    {
        request()->validate([
            'name' => 'required'
        ]);
        Permission::create([
            'name' => request('name'),
            'guard_name' => request('guard_name') ?? 'web'
        ]);

        return back()->with('status', 'New Permissions Saved !');
    }

    public function edit(Permission $permission)
    {
        $permissions = Permission::get();
        return view('permissions.permission.edit', [
            'permissions' => $permissions,
            'permission' => $permission,
            'submit' => 'Update'
        ]);
    }

    public function update(Permission $permission)
    {
        request()->validate([
            'name' => 'required'
        ]);
        $permission->update([
            'name' => request('name'),
            'guard_name' => request('guard_name') ?? 'web'
        ]);

        return redirect()->route('permissions.index')->with('status', 'Permission Updated!');
    }
}
