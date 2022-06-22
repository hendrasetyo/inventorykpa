<?php

namespace App\Http\Controllers\Master;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Unique;

class SatuanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:satuan-list');
        $this->middleware('permission:satuan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:satuan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:satuan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "SATUAN BARANG";
        $satuans = Satuan::latest()->get();

        if (request()->ajax()) {
            return Datatables::of($satuans)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('satuan.edit', ['satuan' => $row->id]);
                    $id = $row->id;
                    return view('master.satuan._formAction', compact('editUrl', 'id'));
                })
                ->make(true);
        }


        return view('master.satuan.index', compact('title'));
    }

    public function create()
    {
        $title = "SATUAN BARANG";
        $satuan = new satuan;
        return view('master.satuan.create', compact('title', 'satuan'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'max:255', 'unique:satuans']
        ]);

        Satuan::create($request->all());
        return redirect()->route('satuan.index')->with('status', 'SATUAN BARANG baru berhasil ditambahkan !');
    }



    public function edit(satuan $satuan)
    {
        $title = "SATUAN";
        return view('master.satuan.edit', compact('title', 'satuan'));
    }


    public function update(Request $request, satuan $satuan)
    {
        $request->validate([
            'nama' => ['required', 'max:255'],
        ]);

        $satuan->update($request->all());
        return redirect()->route('satuan.index')->with('status', 'Data SATUAN berhasil diubah !');
    }

    public function delete(Request $request)
    {
        $data = Satuan::where('id', '=', $request->id)->get(['nama'])->first();
        $id = $request->id;
        $name = $data->nama;

        return view('master.satuan._confirmDelete', compact('name', 'id'));
    }

    public function destroy(Request $request)
    {

        Satuan::destroy($request->id);

        return redirect()->route('satuan.index')->with('status', 'Data SATUAN Berhasil Dihapus !');
    }
}
