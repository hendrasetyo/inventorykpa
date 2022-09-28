<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Imports\NoFakturPajakImport;
use App\Models\NoFakturPajak;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class NoFakturPajakController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:fakturpajak-list');
        $this->middleware('permission:fakturpajak-create', ['only' => ['create', 'store','import']]);
        $this->middleware('permission:fakturpajak-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:fakturpajak-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "No Faktur Pajak";
        $nopajak = NoFakturPajak::get();
        
        if (request()->ajax()) {
            return DataTables::of($nopajak)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('fakturpajak.edit', ['fakturpajak' => $row->id]);
                    $id = $row->id;
                    $status = $row->status;
                    return view('master.fakturpajak._formAction', compact('editUrl', 'id','status'));
                })
                ->make(true);
        }


        return view('master.fakturpajak.index',compact('title'));                
    }

    public function create()
    {
        $title = "Tambah No Faktur Pajak";
        $fakturpajak = new NoFakturPajak;
        return view('master.fakturpajak.create',compact('title','fakturpajak')); 
    }

    public function store(Request $request)
    {
        $data = $request->all();

        NoFakturPajak::create($data);

        return redirect()->route('fakturpajak.index')->with(
            'sukses','Data Berhasil ditambahkan'
        );
    }

    public function edit($id)
    {
        $title = "Tambah No Faktur Pajak";
        $nopajak = NoFakturPajak::findOrFail($id);
        return view('master.fakturpajak.edit',[
            'fakturpajak' => $nopajak,
            'title' => $title
        ]);                
    }

    public function update(Request $request,$id)
    {
        $nopajak = NoFakturPajak::findOrFail($id);
        $nopajak->update($request->all());
        return redirect()->route('fakturpajak.index')->with(
            'sukses','Data Berhasil ditambahkan'
        );
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        return view('master.fakturpajak._confirmDelete', compact('id'));
    }

    public function destroy(Request $request)
    {
        // no faktur pajak tidak bisa dihapus jika sudah dipakai faktur penjualan
        $id = $request->id;
        
        
    }

    public function import(Request $request)
    {        
        Excel::import(new NoFakturPajakImport, $request->file('file')); 
        return back();        
    }

    public function status($id)
    {
        $nopajak = NoFakturPajak::findOrFail($id);
        $nopajak->update([
            'status' => 'Aktif'
        ]);

        return back()->with('sukses','Data Berhasil dirubah');
    }



    
}
