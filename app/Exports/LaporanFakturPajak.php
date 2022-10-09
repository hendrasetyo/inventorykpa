<?php

namespace App\Exports;

use App\Models\FakturPenjualan;
use App\Models\InventoryTransaction;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanFakturPajak implements FromView
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

        if ($this->data['tgl1'] || $this->data['tgl2']) {            
            $nofaktur = FakturPenjualan::where('tanggal','>=',$tgl1)->orWhere('tanggal','<=',$this->data['tgl2'])->with(['customers','nopajak'])->orderBy('id', 'DESC')->get();
        }else{
            $nofaktur = FakturPenjualan::with(['customers','nopajak'])->orderBy('id', 'DESC')->get();
        }                

        return view('laporan.nopajak.export.faktur',[
            'nopajak' => $nofaktur,                            
        ]);
    }
}
