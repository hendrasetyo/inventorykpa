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
                            ->with('subcategories')                                                                                                            
                            ->where('status','Aktif');
        
        $request = $this->data['bulan_id'];

        if ($this->data['bulan_id'] == 'all') {
            $bulan = $product->with('inventory');
        }else{
            $bulan = $product ->with(['inventory' => function($query) use ($request){
                $bulan = "2023-".$request.'-31';
                return $query->where('tanggal','<',$bulan)->latest();
            }]) ;
        }
        
        if ($this->data['kategori_id'] == 'all') {
            $getdata = $bulan;
        }else{
            $getdata = $bulan->where('productcategory_id',$this->data['kategori_id']);
        }

        if ($this->data['merk_id'] == 'all') {
            $merk = $getdata;
        }else{
            $merk = $getdata->where('merk_id',$this->data['merk_id']);
        }

        if ($this->data['ijinedar_id'] == 'all') {
            $ijinedar = $merk;
        }else if ($this->data['ijinedar_id'] == 'iya') {
            $ijinedar = $merk->where('no_ijinedar','<>',null);
        }else{
            $ijinedar = $merk->where('no_ijinedar',null);
        }

        if ($this->data['stok_id'] == 'all') {
            $stok = $ijinedar->where('status','Aktif')->get();
        }else if ($this->data['stok_id'] == 0) {
            $stok = $ijinedar->where('stok','=',$this->data['stok_id'])->where('status','Aktif')->get();
        }
        else{
            $stok = $ijinedar->where('stok','>=',$this->data['stok_id'])->where('status','Aktif')->get();
        }


        
        return view('laporan.stok.export.exportProduct',[
            'product' => $stok
        ]);
        
    }

}
