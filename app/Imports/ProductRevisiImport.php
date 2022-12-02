<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\StokExp;
use DateTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductRevisiImport implements ToModel
{
    protected $no=0;

    public function model(array $row)
    {
        if ($this->no !== 0) {

            $date = new DateTime('2022-11-08');
            $tanggal = $date->format('Y-m-d H:i:s');
            $product = Product::where('kode',$row[0])->first();
            $stok = StokExp::where('product_id',$product->id)->where('created_at','<',$date)->orWhere('created_at',null)->update([
                'qty' => 0
            ]);
        
            
        }
        $this->no++;
        return ;
    }
}
