<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Models\Productcategory;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:productcategory-list');
        $this->middleware('permission:productcategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:productcategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:productcategory-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "product category";
        $productcategories = Productcategory::latest()->get();

        if (request()->ajax()) {
            return Datatables::of($productcategories)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('productcategory.edit', ['productcategory' => $row->id]);
                    $subUrl = route('productsubcategory.index', ['id' => $row->id]);
                    $id = $row->id;
                    return view('master.productcategory._formAction', compact('editUrl', 'subUrl', 'id'));
                })
                ->make(true);
        }


        return view('master.productcategory.index', compact('title'));
    }

    public function create()
    {
        $title = "product category";
        $productcategory = new Productcategory;
        return view('master.productcategory.create', compact('title', 'productcategory'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'max:255']
        ]);

        Productcategory::create($request->all());
        return redirect()->route('productcategory.index')->with('status', 'Product category baru berhasil ditambahkan !');
    }



    public function edit(productcategory $productcategory)
    {
        $title = "productcategory";
        return view('master.productcategory.edit', compact('title', 'productcategory'));
    }


    public function update(Request $request, productcategory $productcategory)
    {
        $request->validate([
            'nama' => ['required', 'max:255'],

        ]);

        $productcategory->update($request->all());
        return redirect()->route('productcategory.index')->with('status', 'Data Product category berhasil diubah !');
    }

    public function delete(Request $request)
    {
        $data = Productcategory::where('id', '=', $request->id)->get(['nama'])->first();
        $id = $request->id;
        $name = $data->nama;

        return view('master.productcategory._confirmDelete', compact('name', 'id'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $productcategory = Productcategory::find($id);
        $productcategory->deleted_by = Auth::user()->id;
        $productcategory->save();

        Productcategory::destroy($request->id);

        return redirect()->route('productcategory.index')->with('status', 'Data Product category Berhasil Dihapus !');
    }
}
