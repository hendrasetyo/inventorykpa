<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Models\Productcategory;
use Yajra\DataTables\DataTables;
use App\Models\Productsubcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductSubCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:productsubcategory-list');
        $this->middleware('permission:productsubcategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:productsubcategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:productsubcategory-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "Sub Kategori";
        $productsubcategories = Productsubcategory::with(['categories']);
        if (request()->ajax()) {
            return Datatables::of($productsubcategories)
                ->addIndexColumn()
                ->addColumn('kategori', function (Productsubcategory $sups) {
                    return $sups->categories->nama;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('productsubcategory.edit', ['productsubcategory' => $row->id]);
                    $id = $row->id;
                    return view('master.productsubcategory._formAction', compact('editUrl', 'id'));
                })
                ->make(true);
        }


        return view('master.productsubcategory.index', compact('title'));
    }

    public function create()
    {
        $title = "Sub Kategori";
        $productsubcategory = new Productsubcategory;
        $productcategories = Productcategory::get();
        return view('master.productsubcategory.create', compact('title', 'productsubcategory', 'productcategories'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'max:255'],
            'productcategory_id' => ['required']
        ]);

        Productsubcategory::create($request->all());
        return redirect()->route('productsubcategory.index')->with('status', 'productsubcategory baru berhasil ditambahkan !');
    }



    public function edit(productsubcategory $productsubcategory)
    {
        $title = "productsubcategory";
        $productcategories = Productcategory::get();
        return view('master.productsubcategory.edit', compact('title', 'productcategories', 'productsubcategory'));
    }


    public function update(Request $request, productsubcategory $productsubcategory)
    {
        $request->validate([
            'nama' => ['required', 'max:255'],
            'productcategory_id' => ['required']
        ]);

        $productsubcategory->update($request->all());
        return redirect()->route('productsubcategory.index')->with('status', 'Data productsubcategory berhasil diubah !');
    }

    public function delete(Request $request)
    {
        $data = Productsubcategory::where('id', '=', $request->id)->get(['nama'])->first();
        $id = $request->id;
        $name = $data->nama;

        return view('master.productsubcategory._confirmDelete', compact('name', 'id'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $productsubcategory = Productsubcategory::find($id);
        $productsubcategory->deleted_by = Auth::user()->id;
        $productsubcategory->save();

        Productsubcategory::destroy($request->id);

        return redirect()->route('productsubcategory.index')->with('status', 'Data productsubcategory Berhasil Dihapus !');
    }
}
