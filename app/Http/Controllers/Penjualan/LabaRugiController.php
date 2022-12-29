<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\BiayaLain;
use App\Models\FakturPenjualan;
use App\Models\FakturPenjualanDetail;
use Illuminate\Http\Request;

class LabaRugiController extends Controller
{
    public function show($id)
    {
        $totalHpp=0;
        $totalHargaBeli=0;
        $totalPpnBeli=0;
        $totalLaba = 0;

        $title = "Faktur penjualan Detail";
        $fakturpenjualan = FakturPenjualan::where('id',$id)->with('nopajak')->first();
        $fakturpenjualandetails = FakturPenjualanDetail::with('products')
            ->where('faktur_penjualan_id', '=', $fakturpenjualan->id)->get();
       

        foreach ($fakturpenjualandetails as $key => $value) {
            $ppnJual = $value->total * 11/100;
            $hargaBersih = $value->total - $value->cn_rupiah + $ppnJual;
            $subtotalpembelian = $value->products->hargabeli * $value->qty;
            $ppnBeli =  11/100 *  $subtotalpembelian;
            $hpp =  $subtotalpembelian + $ppnBeli;
           
            $labaKotor = $hargaBersih - $hpp;

            $totalHpp = (double)$totalHpp +  $hpp;
            $totalHargaBeli = (double) $totalHargaBeli + $subtotalpembelian;
            $totalPpnBeli = (double)$totalPpnBeli +  $ppnBeli;
            $totalLaba = $totalLaba +  $labaKotor;


            $labarugi[] = array(
                'kode' => $value->products->kode,
                'nama' => $value->products->nama,
                'satuan' => $value->products->satuan,
                'qty' => $value->qty,
                'hargajual' => $value->hargajual,
                'diskon_persen' => $value->diskon_persen,
                'diskon_rp' => $value->diskon_rp,
                'hargajual' => $value->hargajual,
                'subtotal' => $value->subtotal,
                'total' => $value->total,
                'cn_rupiah' => $value->cn_rupiah,
                'ppnJual' => $ppnJual,
                'harga_bersih' => $hargaBersih,
                'harga_beli' => $value->products->hargabeli,
                'hpp' => $hpp,
                'ppnBeli' => $ppnBeli,
                'labaKotor' =>  $labaKotor
            );
        }
   

        $totalbiayaLain = BiayaLain::where('fakturpenjualan_id',$id)->sum('nominal');
        $biayalain = BiayaLain::where('fakturpenjualan_id',$id)->with('jenisbiaya')->get();

        $grandTotalLaba = $totalLaba - $totalbiayaLain;

        // dd($labarugi);
        
        
        return view('penjualan.fakturpenjualan.laporan.labarugi', compact(
            'title',  
            'fakturpenjualan', 
            'fakturpenjualandetails',
            'labarugi',
            'biayalain',
            'totalbiayaLain',
            'totalHpp',
            'totalHargaBeli',
            'totalPpnBeli',
            'totalLaba',
            'grandTotalLaba'
        ));
    }
}
