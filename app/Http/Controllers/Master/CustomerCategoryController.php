<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Customer_category;
use Laravolt\Indonesia\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:customercategory-list');
        $this->middleware('permission:customercategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:customercategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:customercategory-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "CUSTOMER CATEGORY";
        $customerscategories = Customer_category::latest()->get();

        if (request()->ajax()) {
            return Datatables::of($customerscategories)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('customercategory.edit', ['customercategory' => $row->id]);
                    $id = $row->id;
                    return view('master.customercategory._formAction', compact('editUrl', 'id'));
                })
                ->make(true);
        }


        return view('master.customercategory.index', compact('title'));
    }

    public function create()
    {
        $title = "Kategori Customer";
        $customercategory = new Customer_category;
        return view('master.customercategory.create', compact('title', 'customercategory'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'max:255']
        ]);

        Customer_category::create($request->all());
        return redirect()->route('customercategory.index')->with('status', 'Kategori Customer baru berhasil ditambahkan !');
    }



    public function edit(Customer_category $customercategory)
    {
        $title = "Customer Category";
        return view('master.customercategory.edit', compact('title', 'customercategory'));
    }


    public function update(Request $request, Customer_category $customercategory)
    {
        $request->validate([
            'nama' => ['required', 'max:255'],

        ]);

        $customercategory->update($request->all());
        return redirect()->route('customercategory.index')->with('status', 'Data Kategori Customer berhasil diubah !');
    }

    public function delete(Request $request)
    {
        $data = Customer_category::where('id', '=', $request->id)->get(['nama'])->first();
        $id = $request->id;
        $name = $data->nama;

        return view('master.customercategory._confirmDelete', compact('name', 'id'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $customercategory = Customer_category::find($id);
        $customercategory->deleted_by = Auth::user()->id;
        $customercategory->save();

        Customer_category::destroy($request->id);

        return redirect()->route('customercategory.index')->with('status', 'Data Kategori Customer Berhasil Dihapus !');
    }
}
