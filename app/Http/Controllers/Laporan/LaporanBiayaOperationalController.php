<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\LaporanBiayaOperasional;
use App\Http\Controllers\Controller;
use App\Models\JenisBiaya;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanBiayaOperationalController extends Controller
{
    public function index()
    {
        $title = "Laporan Biaya Operational";
        $biaya = JenisBiaya::get();

        return view('laporan.biayaoperational.filter',compact('title','biaya'));        
    }

    public function filter(Request $request)
    {   
        $title = 'Filter Biaya Operational';
        $data = $request->all();

        $tgl1 = Carbon::parse($data['tgl1'])->format('Y-m-d');
        $tgl2 = Carbon::parse($data['tgl2'])->format('Y-m-d');   
        $biaya = DB::table('biaya_operationals as bo')                
                ->join('banks as b','bo.bank_id','=','b.id')
                ->join('jenis_biayas as jb','bo.jenis_biaya_id','=','jb.id');
        


        if ($data['tgl1']) {            
            if (!$data['tgl2']) {
                $tanggalFilter=$biaya->where('bo.tanggal','>=',$tgl1);
                                
            }else{
                $tanggalFilter=$biaya->where('bo.tanggal','>=',$tgl1)
                                ->where('bo.tanggal','<=',$tgl2);
            }
        }elseif($data['tgl2']){
            if (!$data['tgl1']) {
                $tanggalFilter=$biaya->where('bo.tanggal','<=',$tgl2);
            }else{
                $tanggalFilter=$biaya->where('bo.tanggal','>=',$tgl1)
                                ->where('bo.tanggal','<=',$tgl2);
            }
        }else{
              $tanggalFilter = $biaya;
        }

        if ($data['jenis_biaya_id'] !== 'all' ) {
            $jenisbiaya = $tanggalFilter->where('bo.jenis_biaya_id','=',$data['jenis_biaya_id']);                    
        }else{
            $jenisbiaya = $tanggalFilter;
        }


        $datafilter = $jenisbiaya->select('bo.*','jb.nama', 'b.nama as nama_bank')->get();

        if (count($datafilter) <= 0) {
            return redirect()->back()->with('status_danger', 'Data tidak ditemukan');
        }
        

        return view('laporan.biayaoperational.result',[
            'title' => $title,
            'data' => $datafilter,
            'form' => $data
        ]);
    }

    public function export(Request $request)
    {
        $data = $request->all();
        $now = Carbon::parse(now())->format('Y-m-d');
        return Excel::download(new LaporanBiayaOperasional($data), 'laporanbiayaoperasional-'.$now.'.xlsx');

    }
}
