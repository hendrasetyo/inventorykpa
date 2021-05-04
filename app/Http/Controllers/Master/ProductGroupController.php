<?php

namespace App\Http\Controllers\Master;

use App\Models\Productgroup;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductGroupController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:productgroup-list');
        $this->middleware('permission:productgroup-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:productgroup-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:productgroup-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "Produk Group";
        $productgroups = Productgroup::latest()->get();

        if (request()->ajax()) {
            return Datatables::of($productgroups)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('productgroup.edit', ['productgroup' => $row->id]);
                    $id = $row->id;
                    return view('master.productgroup._formAction', compact('editUrl', 'id'));
                })
                ->make(true);
        }


        return view('master.productgroup.index', compact('title'));
    }

    public function create()
    {
        $title = "Produk Group";
        $productgroup = new Productgroup;
        return view('master.productgroup.create', compact('title', 'productgroup'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'max:255']
        ]);

        Productgroup::create($request->all());
        return redirect()->route('productgroup.index')->with('status', 'Produk Group baru berhasil ditambahkan !');
    }



    public function edit(Productgroup $productgroup)
    {
        $title = "Product Group";
        return view('master.productgroup.edit', compact('title', 'productgroup'));
    }


    public function update(Request $request, Productgroup $productgroup)
    {
        $request->validate([
            'nama' => ['required', 'max:255'],

        ]);

        $productgroup->update($request->all());
        return redirect()->route('productgroup.index')->with('status', 'Data Product Group berhasil diubah !');
    }

    public function delete(Request $request)
    {
        $data = Productgroup::where('id', '=', $request->id)->get(['nama'])->first();
        $id = $request->id;
        $name = $data->nama;

        return view('master.productgroup._confirmDelete', compact('name', 'id'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $productgroup = Productgroup::find($id);
        $productgroup->deleted_by = Auth::user()->id;
        $productgroup->save();

        Productgroup::destroy($request->id);

        return redirect()->route('productgroup.index')->with('status', 'Data Product Group Berhasil Dihapus !');
    }
}
