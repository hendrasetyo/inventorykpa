<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Imports\NoFakturPajakImport;
use App\Imports\NoKpaImport;
use App\Models\FakturPenjualan;
use App\Models\LogNoFakturPajak;
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
        $nopajak = NoFakturPajak::orderBy('id');
        
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
        $fakturpenjualan = FakturPenjualan::where('pajak_id',$request->id)->get();

        if (count($fakturpenjualan) > 0) {
            return back()->with('error','no pajak tidak bisa dihapus karena telah digunakan di faktur penjualan');
        }
        
        // SAVE KE LOG
        LogNoFakturPajak::create([
            'jenis' => 'NF',
            'jenis_id'=> 'Tidak Ada',
            'nofaktur_id'   => $request->id
        ]);
        
        NoFakturPajak::where('id',$request->id)->delete();

        return back()->with('sukses','No Pajak berhasil dihapus');                        
    }

    public function import(Request $request)
    {        
        Excel::import(new NoFakturPajakImport, $request->file('file')); 
        return back();        
    }

    public function status($id)
    {
         // no faktur pajak tidak bisa dihapus jika sudah dipakai faktur penjualan
         $fakturpenjualan = FakturPenjualan::where('pajak_id',$id)->get();

         if (count($fakturpenjualan) > 0) {
             return back()->with('error','no pajak tidak dapat diubah karena telah digunakan di faktur penjualan');
         }
        
         
        $nopajak = NoFakturPajak::findOrFail($id);

        $nopajak->update([
            'status' => 'Aktif'
        ]);

        return back()->with('sukses','Data Berhasil dirubah');
    }


    public function importnokpa(Request $request)
    {
        Excel::import(new NoKpaImport, $request->file('file')); 
        return back(); 
    }



    
}
