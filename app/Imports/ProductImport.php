<?php

namespace App\Imports;

use App\Models\AdjustmentStok;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Traits\CodeTrait;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Str;

class ProductImport implements ToModel
{
    protected $no=0;
    use CodeTrait;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {        
        if ($this->no !== 0) {
            // cek produk berdasarkan kode 
            $product = Product::where('kode',$row[0])->first();            
            
            // cek stok berdasarkan qty
            // kurangi dari qty inputan - stok 
            $stok = $row[2] - $product->stok;  
            $tanda = 1;          
            if ($stok < 0) {
                $tanda = -1;
            }

            $tahun = Carbon::now()->format('y');
            $bulan = Carbon::now()->format('m');

            $kode = 'AJS'.$tahun.$bulan.rand(1000,9999) ;        

            // save di tabel adjustmen stok
            $ajs = AdjustmentStok::create([
                'product_id' => $product->id,
                'qty' => $stok,                
                'jenis' => 'nonexpired',
                'kode' => $kode
            ]);
            
            // perubahan simpan di inventory transaction
            $inv = InventoryTransaction::create([
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'product_id' => $product->id,
                'qty' => $stok * $tanda,
                'stok' => $row[2],
                'hpp' => $product->hpp,
                'jenis' => 'AJS',
                'jenis_id' => $kode,
            ]);

            $product->update([
                'stok' => $row[2]
            ]);

        }


        $this->no++;

        return ;
        
    }
}
