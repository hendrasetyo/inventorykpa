<?php

namespace App\Imports;
use App\Models\TempProduct;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class NewProductImport implements ToModel
{
    protected $no=0;
    
    
    public function model(array $row)
    {
        
        if ($this->no !== 0) {            

               
                $tempproducts = TempProduct::create([
                    'nama' => $row[0],
                    'kode' => rand(100,999),
                    'productgroup_id' => $row[2],
                    'jenis' => $row[3],
                    'merk_id' => $row[4],
                    'tipe' => $row[5],
                    'ukuran' => $row[6],
                    'kemasan' => $row[7],
                    'satuan' => $row[8],
                    'katalog' => $row[9],
                    'asal_negara' => $row[10],
                    'pabrikan' => $row[11],
                    'no_ijinedar' => $row[13],
                    'exp_ijinedar' => Carbon::parse($row[12])->format('Y-m-d'),
                    'productcategory_id' => $row[14],
                    'productsubcategory_id' => $row[15],
                    'hargajual' => $row[16],
                    'hargabeli' => $row[17],
                    'hpp' => $row[18],
                    'diskon_persen' => $row[19],
                    'diskon_rp' => $row[20],
                    'stok' => 0,                
                    'keterangan' => $row[23],
                    'status' => $row[25],
                    'status_exp' => $row[24],
                    'stok_canvassing' => 0,
                    'user_id' => auth()->user()->id
                ]);
        }

        $this->no++;

        return ;
    }
}
