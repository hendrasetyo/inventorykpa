<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanSalesController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $title = "Laporan Kunjungan Sales";

        return view('laporan.laporansales.index',compact('title'));
    }


    public function datatable(Request $request)
    {
        # code...
    }
}
