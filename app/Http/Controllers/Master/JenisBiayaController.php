<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BiayaOperational;
use App\Models\JenisBiaya;
use Illuminate\Http\Request;

class JenisBiayaController extends Controller
{
    public function index()
    {
        $title = 'Jenis Biaya';
        $jenisbiaya = JenisBiaya::get();

        return view('master.jenisbiaya.index',compact('title','jenisbiaya'));
    }

    
    public function create()
    {
        $title = 'Jenis Biaya';
        
        return view('master.jenisbiaya.create',compact('title'));
    }

   
    public function store(Request $request)
    {
    
        JenisBiaya::create([
            'nama' => $request->nama,
            'no_akun' => $request->no_akun,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('jenisbiaya.index')->with('sukses','data berhasil ditambajan');
    }

   
    public function show($id)
    {
        
    }

  
    public function edit($id)
    {
        $jenisbiaya = JenisBiaya::findOrFail($id);
        $title = 'Jenis Biaya';

        return view('master.jenisbiaya.edit',compact('jenisbiaya','title'));
    }

    public function update(Request $request, $id)
    {
        $jenisbiaya = JenisBiaya::findOrFail($id);
        $title = 'Jenis Biaya';

        $jenisbiaya->update([
            'nama' => $request->nama,
            'no_akun' => $request->no_akun,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('jenisbiaya.index')->with('sukses','data berhasil ditambajan');
    }

    public function delete(Request $request)
    {
        $data = JenisBiaya::where('id', '=', $request->id)->get(['nama'])->first();
        $id = $request->id;
        $name = $data->nama;

        return view('master.jenisbiaya._confirmDelete', compact('name', 'id'));
    }

   
    public function destroy(Request $request)
    {
        $jenisbiaya = JenisBiaya::findOrFail($request->id);
        $biayaoperational = BiayaOperational::where('jenis_biaya_id',$request->id)->first();

        if ($biayaoperational) {
            return redirect()->route('jenisbiaya.index')->with('error','Jenis biaya ini telah dipakai di biaya operational');    
        }else{
            $jenisbiaya->delete();        
            return redirect()->route('jenisbiaya.index')->with('sukses','data berhasil dihapus');
        }        
    
    }
}
