<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ProductExport implements FromView
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
            $getdata = $product;
        }else{
            $getdata = $product->where('productcategory_id',$this->data['kategori_id']);
        }

        if ($this->data['merk_id'] == 'all') {
            $merk = $getdata;
        }else{
            $merk = $getdata->where('merk_id',$this->data['merk_id']);
        }

        if ($this->data['stok_id'] == 'all') {
            $stok = $merk->get();
        }else if ($this->data['stok_id'] == 0) {
            $stok = $merk->where('stok','=',$this->data['stok_id'])->get();
        }
        else{
            $stok = $merk->where('stok','>=',$this->data['stok_id'])->get();
        }

        return view('laporan.stok.export.exportProduct',[
            'product' => $stok
        ]);
        
    }

}
