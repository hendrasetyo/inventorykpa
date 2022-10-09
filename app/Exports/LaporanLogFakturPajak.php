<?php

namespace App\Exports;

use App\Models\InventoryTransaction;
use App\Models\LogNoFakturPajak;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanLogFakturPajak implements FromView
{

    protected $data ;

    public function __construct($data)
    {
        $this->data = $data;

    }
    public function view(): View
    {   
        // dd($this->data);
                                
        $logfaktur = LogNoFakturPajak::with(['creator','updater'])->where('nofaktur_id',$this->data['id'])->orderBy('id','DESC')->get();

        return view('laporan.nopajak.export.logfaktur',compact('logfaktur'));
    }
}
