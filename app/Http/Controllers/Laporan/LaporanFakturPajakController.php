<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\LaporanFakturPajak;
use App\Exports\LaporanLogFakturPajak;
use App\Http\Controllers\Controller;
use App\Models\FakturPenjualan;
use App\Models\LogNoFakturPajak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LaporanFakturPajakController extends Controller
{
    public function index()
    {
        $title = 'Laporan No Faktur Pajak';

        return view('laporan.nopajak.filter',compact('title'));
    }

    public function result(Request $request)
    {
        $title = 'Laporan No Faktur Pajak';
        $data = $request->all();        
        
        $tgl1 = Carbon::parse($data['tgl1'])->format('Y-m-d');
        $tgl2 = Carbon::parse($data['tgl2'])->format('Y-m-d');     

        if ($data['tgl1'] || $data['tgl2']) {            
            $nofaktur = FakturPenjualan::where('tanggal','>=',$tgl1)->orWhere('tanggal','<=',$data['tgl2'])->with(['customers','nopajak'])->orderBy('id', 'DESC')->get();
        }else{
            $nofaktur = FakturPenjualan::with(['customers','nopajak'])->orderBy('id', 'DESC')->get();
        }                

        return view('laporan.nopajak.result',[
            'nopajak' => $nofaktur,
            'title' => $title,
            'form' => $data            
        ]);
    }

    public function detail($id)
    {

        $title = 'Detail No Faktur';        
        $logfaktur = LogNoFakturPajak::with(['creator','updater'])->where('nofaktur_id',$id)->orderBy('id','DESC')->get();
        $id = $id;

        return view('laporan.nopajak.detail',compact('title','logfaktur','id'));

    }

    public function exportLogFaktur(Request $request)
    {
        $data = $request->all();
        $now = Carbon::parse(now())->format('Y-m-d');
        return Excel::download(new LaporanLogFakturPajak($data), 'laporanlogfaktur-'.$now.'.xlsx');
    }

    public function exportFaktur(Request $request)
    {        
        $data = $request->all();
        $now = Carbon::parse(now())->format('Y-m-d');
        return Excel::download(new LaporanFakturPajak($data), 'laporanlogfakturpajak-'.$now.'.xlsx');
    }

}
