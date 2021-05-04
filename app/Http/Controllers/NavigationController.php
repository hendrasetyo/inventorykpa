<?php

namespace App\Http\Controllers;

use App\Models\Navigation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class NavigationController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:navigation-list');
        $this->middleware('permission:navigation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:navigation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:navigation-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "Navigations";
        $navs = Navigation::where('id', '<>', '1')->get();
        if (request()->ajax()) {

            return Datatables::of($navs)
                ->addIndexColumn()
                ->addColumn('parent_name', function (Navigation $navx) {
                    return $navx->parent->name;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('navigation.edit', ['navigation' => $row->id]);
                    $id = $row->id;
                    return view('navigation._formAction', compact('editUrl', 'id'));
                })
                ->make(true);
        }

        return view('navigation.index', compact('title'));
    }

    public function create()
    {
        $title = "Navigations";
        $navigation = new Navigation;
        $permissions = Permission::get();
        $parents  = Navigation::where('parent_id', '=', '1')->get();
        $navs = Navigation::whereNotNull('url')->get();
        return view('navigation.create', compact('title', 'permissions', 'parents', 'navs', 'navigation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permission_name' => 'required',
        ]);

        // Navigation::create([
        //     'name' => request('name'),
        //     'url' => request('url') ?? null,
        //     'parent_id' => request('parent_id') ?? null,
        //     'permission_name' => request('permission_name'),
        //     'icon' => request('icon') ?? null
        // ]);

        Navigation::create($request->all());
        return redirect()->route('navigation.index')->with('status', 'Navigations Saved');
    }

    public function edit(Navigation $navigation)
    {
        $title = "Navigations";
        $permissions = Permission::get();
        $parents  = Navigation::where('url', null)->get();
        $navs = Navigation::whereNotNull('url')->get();
        return view('navigation.edit', compact('title', 'navigation', 'parents', 'navs', 'permissions'));
    }

    public function update(Request $request, Navigation $navigation)
    {
        $request->validate([
            'name' => 'required',
            'permission_name' => 'required',
        ]);

        $navigation->update($request->all());
        return redirect()->route('navigation.index')->with('status', 'Navigations Updated');
    }


    public function delete(Request $request)
    {
        $data = Navigation::where('id', '=', $request->id)->get(['name'])->first();
        $id = $request->id;
        $name = $data->name;

        return view('navigation._confirmDelete', compact('name', 'id'));
    }

    public function destroy(Request $request)
    {
        Navigation::destroy($request->id);
        return redirect()->route('navigation.index')->with('status', 'Success, Data Navigation Deleted !');
    }
}
