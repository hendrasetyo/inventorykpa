<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Imports\AbsensiImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiController extends Controller
{
    public function index ()
    {        
        $title = 'Absensi';
        return view('hrd.absensi.index',compact('title'));
    }

    public function import (Request $request)
    {
        Excel::import(new AbsensiImport, $request->file('file_import'));    
        return back();
    }

    
    
}
