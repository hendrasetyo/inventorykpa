<?php

namespace App\Exports;

use App\Models\InventoryTransaction;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanKartuStok implements FromView
{

    protected $id ;

    public function __construct($id)
    {
        $this->id = $id;

    }
    public function view(): View
    {   
        

        $kartustok = InventoryTransaction::with('product')->where('product_id', '=', $this->id)
                     ->orderByDesc('id')->get();        

        return view('laporan.stok.export.kartustokexport',[
            'kartustok' => $kartustok
        ]);
    }
}
