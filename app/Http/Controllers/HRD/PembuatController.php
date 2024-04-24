<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\HRD\Pembuat;
use Illuminate\Http\Request;

class PembuatController extends Controller
{
    public function index ()
    {
        $title = 'Pembuat';
        $pembuat  = Pembuat::get();
        return view('hrd.pembuat.index',compact('title','pembuat'));
    }  
    
    public function create ()
    {
        $title = 'Pembuat';
        return view('hrd.pembuat.create',compact('title'));
    }

    public function store (Request $request)
    {
        $data = Pembuat::create([
            'nama' => $request->nama,
            'inisial' => $request->inisial
        ]);

        return back();
    }

    public function update (Request $request,$id)
    {
        
        $data = Pembuat::where('id',$id)->update([
            'nama' => $request->nama,
            'inisial' => $request->inisial
        ]);

        return back();
    }


    public function delete ($id)
    {
        Pembuat::where('id',$id)->delete();

        return back();

    }
    
    
}
