<?php

namespace App\Exports;

use App\Models\InventoryTransaction;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanBiayaOperasional implements FromView
{

    protected $data ;

    public function __construct($data)
    {
        $this->data = $data;

    }
    public function view(): View
    {   
                                
        $tgl1 = Carbon::parse($this->data['tgl1'])->format('Y-m-d');
        $tgl2 = Carbon::parse($this->data['tgl2'])->format('Y-m-d');   
        $biaya = DB::table('biaya_operationals as bo')                
                ->join('banks as b','bo.bank_id','=','b.id')
                ->join('jenis_biayas as jb','bo.jenis_biaya_id','=','jb.id');
        


        if ($this->data['tgl1']) {            
            if (!$this->data['tgl2']) {
                $tanggalFilter=$biaya->where('bo.tanggal','>=',$tgl1);
                                
            }else{
                $tanggalFilter=$biaya->where('bo.tanggal','>=',$tgl1)
                                ->where('bo.tanggal','<=',$tgl2);
            }
        }elseif($this->data['tgl2']){
            if (!$this->data['tgl1']) {
                $tanggalFilter=$biaya->where('bo.tanggal','<=',$tgl2);
            }else{
                $tanggalFilter=$biaya->where('bo.tanggal','>=',$tgl1)
                                ->where('bo.tanggal','<=',$tgl2);
            }
        }else{
              $tanggalFilter = $biaya;
        }

        if ($this->data['jenis_biaya_id'] !== 'all' ) {
            $jenisbiaya = $tanggalFilter->where('bo.jenis_biaya_id','=',$this->data['jenis_biaya_id']);                    
        }else{
            $jenisbiaya = $tanggalFilter;
        }


        $datafilter = $jenisbiaya->select('bo.*','jb.nama', 'b.nama as nama_bank')->get();

        return view('laporan.biayaoperational.export.export',[
            'data' => $datafilter
        ]);
    }
}
