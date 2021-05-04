<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Models\Kategoripesanan;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KategoriPesananController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:kategoripesanan-list');
        $this->middleware('permission:kategoripesanan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:kategoripesanan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:kategoripesanan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "Kategori Surat Pesanan";
        $kategoripesanans = Kategoripesanan::latest()->get();

        if (request()->ajax()) {
            return Datatables::of($kategoripesanans)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('kategoripesanan.edit', ['kategoripesanan' => $row->id]);
                    $id = $row->id;
                    return view('master.kategoripesanan._formAction', compact('editUrl', 'id'));
                })
                ->make(true);
        }


        return view('master.kategoripesanan.index', compact('title'));
    }

    public function create()
    {
        $title = "Kategori Surat Pesanan";
        $kategoripesanan = new Kategoripesanan;
        return view('master.kategoripesanan.create', compact('title', 'kategoripesanan'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'max:255']
        ]);

        Kategoripesanan::create($request->all());
        return redirect()->route('kategoripesanan.index')->with('status', 'kategoripesanan baru berhasil ditambahkan !');
    }



    public function edit(Kategoripesanan $kategoripesanan)
    {
        $title = "Kategori Surat Pesanan";
        return view('master.kategoripesanan.edit', compact('title', 'kategoripesanan'));
    }


    public function update(Request $request, Kategoripesanan $kategoripesanan)
    {
        $request->validate([
            'nama' => ['required', 'max:255'],

        ]);

        $kategoripesanan->update($request->all());
        return redirect()->route('kategoripesanan.index')->with('status', 'Data kategoripesanan berhasil diubah !');
    }

    public function delete(Request $request)
    {
        $data = Kategoripesanan::where('id', '=', $request->id)->get(['nama'])->first();
        $id = $request->id;
        $name = $data->nama;

        return view('master.kategoripesanan._confirmDelete', compact('name', 'id'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $kategoripesanan = Kategoripesanan::find($id);
        $kategoripesanan->deleted_by = Auth::user()->id;
        $kategoripesanan->save();

        Kategoripesanan::destroy($request->id);

        return redirect()->route('kategoripesanan.index')->with('status', 'Data kategori pesanan Berhasil Dihapus !');
    }
}
