<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanStockExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function view(): View
    {   

        $product = Product::with('categories')
                            ->with('merks')
                            ->with('categories')
                            ->with('subcategories');

        if ($this->data['kategori_id'] == 'all') {
            $getdata = $product->get();
        }else{
            $getdata = $product->where('productcategory_id',$this->data['kategori_id'])->get();
        }


          return view('laporan.stok.export.exportProduct',[
            'product' => $getdata
        ]);


    }
}
