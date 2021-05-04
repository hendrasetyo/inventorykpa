<?php

namespace App\Http\Controllers\Permissions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    //
    public function index()
    {
        $roles = Role::get();
        $role = new Role;

        if (request()->ajax()) {
            return Datatables::of($roles)
                ->addIndexColumn()
                ->editColumn('created_at', function ($roles) {
                    return $roles->created_at ? with(new Carbon($roles->created_at))->format('d M Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('roles.edit', ['role' => $row->id]);
                    $id = $row->id;
                    return view('permissions.roles._formAction', compact('editUrl', 'id'));
                })
                ->make(true);
        }
        return view('permissions.roles.index', compact('roles', 'role'));
    }

    public function store()
    {
        request()->validate([
            'name' => 'required'
        ]);
        Role::create([
            'name' => request('name'),
            'guard_name' => request('guard_name') ?? 'web'
        ]);

        return back()->with('status', 'New Role Saved !');
    }

    public function edit(Role $role)
    {
        $roles = Role::get();
        return view('permissions.roles.edit', [
            'roles' => $roles,
            'role' => $role,
            'submit' => 'Update'
        ]);
    }

    public function update(Role $role)
    {
        request()->validate([
            'name' => 'required'
        ]);
        $role->update([
            'name' => request('name'),
            'guard_name' => request('guard_name') ?? 'web'
        ]);

        return redirect()->route('roles.index')->with('status', 'Role Updated!');
    }
}
