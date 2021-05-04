<?php

namespace App\Http\Controllers\Master;

use App\Models\Komoditas;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KomoditasController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:komoditas-list');
        $this->middleware('permission:komoditas-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:komoditas-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:komoditas-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "KOMODITAS";
        $komoditass = Komoditas::latest()->get();

        if (request()->ajax()) {
            return Datatables::of($komoditass)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('komoditas.edit', ['komoditas' => $row->id]);
                    $id = $row->id;
                    return view('master.komoditas._formAction', compact('editUrl', 'id'));
                })
                ->make(true);
        }


        return view('master.komoditas.index', compact('title'));
    }

    public function create()
    {
        $title = "KOMODITAS";
        $komoditas = new Komoditas;
        return view('master.komoditas.create', compact('title', 'komoditas'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'max:255']
        ]);

        Komoditas::create($request->all());
        return redirect()->route('komoditas.index')->with('status', 'KOMODITAS baru berhasil ditambahkan !');
    }



    public function edit(Komoditas $komoditas)
    {
        $title = "KOMODITAS";
        return view('master.komoditas.edit', compact('title', 'komoditas'));
    }


    public function update(Request $request, Komoditas $komoditas)
    {
        $request->validate([
            'nama' => ['required', 'max:255'],

        ]);

        $komoditas->update($request->all());
        return redirect()->route('komoditas.index')->with('status', 'Data KOMODITAS berhasil diubah !');
    }

    public function delete(Request $request)
    {
        $data = Komoditas::where('id', '=', $request->id)->get(['nama'])->first();
        $id = $request->id;
        $name = $data->nama;

        return view('master.komoditas._confirmDelete', compact('name', 'id'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $komoditas = Komoditas::find($id);
        $komoditas->deleted_by = Auth::user()->id;
        $komoditas->save();

        Komoditas::destroy($request->id);

        return redirect()->route('komoditas.index')->with('status', 'Data KOMODITAS Berhasil Dihapus !');
    }
}
