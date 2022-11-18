<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransaction;
use App\Models\PenerimaanBarang;
use App\Models\PengirimanBarang;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function update()
    {
        $inv = InventoryTransaction::get();

        foreach ($inv as $key ) {
            $sj = PengirimanBarang::where('kode',$key->jenis_id)->with('customers')->first();
            $pb = PenerimaanBarang::where('kode',$key->jenis_id)->with('suppliers')->first();
        
            if ($sj) {
                InventoryTransaction::where('id',$key->id)->update([
                    'customer' => $sj->customers->nama
                ]);
            }

            if ($pb) {
                InventoryTransaction::where('id',$key->id)->update([
                    'supplier' => $pb->suppliers->nama
                ]);
            }

           
        }

        return back();
    }
}
