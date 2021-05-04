<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Supplier_category;
use Laravolt\Indonesia\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SupplierCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:suppliercategory-list');
        $this->middleware('permission:suppliercategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:suppliercategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:suppliercategory-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "SUPPLIER CATEGORY";
        $suppliercategories = Supplier_category::latest()->get();

        if (request()->ajax()) {
            return Datatables::of($suppliercategories)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('suppliercategory.edit', ['suppliercategory' => $row->id]);
                    $id = $row->id;
                    return view('master.suppliercategory._formAction', compact('editUrl', 'id'));
                })
                ->make(true);
        }


        return view('master.suppliercategory.index', compact('title'));
    }

    public function create()
    {
        $title = "Kategori Supplier";
        $suppliercategory = new Supplier_category;
        return view('master.suppliercategory.create', compact('title', 'suppliercategory'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'max:255']
        ]);

        Supplier_category::create($request->all());
        return redirect()->route('suppliercategory.index')->with('status', 'Kategori Customer baru berhasil ditambahkan !');
    }



    public function edit(Supplier_category $suppliercategory)
    {
        $title = "Customer Category";
        return view('master.suppliercategory.edit', compact('title', 'suppliercategory'));
    }


    public function update(Request $request, Supplier_category $suppliercategory)
    {
        $request->validate([
            'nama' => ['required', 'max:255'],

        ]);

        $suppliercategory->update($request->all());
        return redirect()->route('suppliercategory.index')->with('status', 'Data Kategori Customer berhasil diubah !');
    }

    public function delete(Request $request)
    {
        $data = Supplier_category::where('id', '=', $request->id)->get(['nama'])->first();
        $id = $request->id;
        $name = $data->nama;

        return view('master.suppliercategory._confirmDelete', compact('name', 'id'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $suppliercategory = Supplier_category::find($id);
        $suppliercategory->deleted_by = Auth::user()->id;
        $suppliercategory->save();

        Supplier_category::destroy($request->id);

        return redirect()->route('suppliercategory.index')->with('status', 'Data Kategori Customer Berhasil Dihapus !');
    }
}
