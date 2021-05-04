<?php

namespace App\Http\Controllers\Master;

use App\Models\Sales;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class SalesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:sales-list');
        $this->middleware('permission:sales-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sales-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sales-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        $title = "SALESMAN";
        $saless = Sales::get();

        if (request()->ajax()) {
            return Datatables::of($saless)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('sales.edit', ['sales' => $row->id]);
                    $id = $row->id;
                    return view('master.sales._formAction', compact('editUrl', 'id'));
                })
                ->make(true);
        }

        return view('master.sales.index', compact('title'));
    }


    public function create()
    {
        $title = "SALESMAN";
        $sales = new Sales;
        return view('master.sales.create', compact('title', 'sales'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        Sales::create($request->all());
        return redirect()->route('sales.index')->with('status', 'Salesman baru berhasil ditambahkan !');
    }


    public function show($id)
    {
        //
    }


    public function edit(Sales $sales)
    {
        $title = "SALESMAN";
        return view('master.sales.edit', compact('title', 'sales'));
    }


    public function update(Request $request, Sales $sales)
    {
        $request->validate([
            'nama' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $sales->update($request->all());
        return redirect()->route('sales.index')->with('status', 'Data Salesman berhasil diubah !');
    }

    public function delete(Request $request)
    {
        $data = Sales::where('id', '=', $request->id)->get(['nama'])->first();
        $id = $request->id;
        $name = $data->nama;

        return view('master.sales._confirmDelete', compact('name', 'id'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $sales = Sales::find($id);
        $sales->deleted_by = Auth::user()->id;
        $sales->save();

        Sales::destroy($request->id);

        return redirect()->route('sales.index')->with('status', 'Data Salesman Berhasil Dihapus !');
    }
}
