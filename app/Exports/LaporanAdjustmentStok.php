<?php

namespace App\Exports;

use App\Models\InventoryTransaction;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanAdjustmentStok implements FromView
{

    protected $data ;

    public function __construct($data)
    {
        $this->data = $data;

    }
    public function view(): View
    {   
                                
        $adjustment = DB::table('adjustment_stoks as as')
                    ->join('products as p','as.product_id','=','p.id');
                    
        if ($this->data['adjustment'] == 'all') {
            $filter = $adjustment;
        }else{
            $filter = $adjustment->where('as.jenis',$this->data['adjustment']);
        }

        $data = $filter->select('as.*','p.*','as.kode as kode_adjustment','as.qty as qty_adjustment','as.created_at as tanggal_adjustment')->get();

        return view('laporan.stok.export.adjustmentstok',[
            'data' => $data
        ]);
    }
}
