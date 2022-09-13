<?php

namespace App\Http\Controllers\Permissions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class AssignPermissionController extends Controller
{
    //
    public function index()
    {
        $roles = Role::get();
        //$role = new Role;
        if (request()->ajax()) {
            return Datatables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('assignpermission.edit', ['role' => $row->id]);
                    $id = $row->id;
                    return view('permissions.assign._formAction', compact('editUrl', 'id'));
                })
                ->make(true);
        }

        return view('permissions.assign.index', compact('roles'));
    }

    public function edit(Role $role)
    {
        $permission = Permission::all();
        $datas = array();
        $k = 0;
        for ($i = 0; $i < $permission->count() / 4; $i++) {
            for ($j = 0; $j < 5; $j++) {
                if ($j == 0) {
                    $datas[$i][$j] = ucfirst(explode('-', $permission[$k]->name)[0]);
                } else {
                    $datas[$i][$j] = $permission[$k];
                    $k++;
                }
            }
        }
        
        //$roles = Role::get();
        //dd($role->permissions());

        return view('permissions.assign.sync', compact('datas', 'role'));
    }

    public function sync(Role $role)
    {
        request()->validate([
            'permission' => 'required'
        ]);

        $role->syncPermissions(request('permission'));
        return redirect()->route('assignpermission.edit', $role)->with('status', 'The permissions has been synced.');
    }
}
