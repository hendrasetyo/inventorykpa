<?php

namespace App\Http\Controllers;

use App\Models\FakturPenjualan;
use App\Models\Kategoripesanan;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {        
        $kategori = Kategoripesanan::get();
        $produk = Product::get();
        $months =  [];
        for ($i = 1; $i <=12; $i++) {
            $months[] = [
                'nama' => date('F', mktime(0,0,0,$i)),
                'id' => $i
            ];
        }

        return view('home',[
            'kategori' => $kategori,
            'bulan' => $months,
            'produk' => $produk
        ]);

       
    }


    public function chartyear(Request $request)
    {
        $results = DB::table('faktur_penjualans as fp')
                ->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                ->where('fp.deleted_at','=',null)
                ->orderBy('fp.tanggal');
                 

        if ($request->year) {
            $res=$results->whereYear('fp.tanggal',$request->year);       
        }else{
            $res=$results;
        }

        if ($request->kategori !== 'All') {            
            $kategori=$res->where('pp.kategoripesanan_id',$request->kategori); 
        }else{
            $kategori=$res;
        }
        $bulan = $kategori;
        $tipe = $bulan->groupBy(DB::raw("DATE_FORMAT(fp.tanggal, '%m-%Y')"))
        ->select(
            DB::raw("DATE_FORMAT(fp.tanggal, '%m') as tanggal_penjualan"),
            DB::raw("sum(fp.grandtotal) as grandtotal_penjualan")
        ); 
        
        $hasil= $tipe->get();
        
        
        $laba = array();  
        $data=[]; 
                        
        foreach ($hasil as $key => $value) {
            $data[(int)$value->tanggal_penjualan] = [
                'grandtotal' => (int)$value->grandtotal_penjualan
            ];
        }
        
        
        for ($i=0; $i <= 12; $i++) { 
            if ($i==0) {
                $laba[] = 0;
            }else{
                if (!empty($data[$i])) {
                    $laba[] = $data[$i]['grandtotal'];
                }else{
                    $laba[] = 0;
                }
            }
            
        }

        for ($i = 0; $i <=12; $i++) {
            if ($i==0) {
                $months[] = 0;
            }else{ 
                $months[] = date('F', mktime(0,0,0,$i));
            }
            
        }

        
        return response()->json([
            'laba' => $laba,
            'bulan' => $months
        ]);
    }

    public function chartkategori(Request $request)
    {
        $results = DB::table('faktur_penjualans as fp')
                    ->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                    ->join('kategoripesanans as kp','pp.kategoripesanan_id','=','kp.id')
                    ->where('fp.deleted_at','=',null);

        if ($request->year) {
            $res=$results->whereYear('fp.tanggal',$request->year);       
        }else{
            $res=$results;
        }

      

        $hasil = $res->select(
                        'kp.nama as kategori',
                        DB::raw("sum(fp.grandtotal) as grandtotal_penjualan")
                    )
                    ->groupBy('pp.kategoripesanan_id')
                    ->get(); 

        $datakategori = [];
        $sum = 0;

        foreach ($hasil as $value) {
                $sum += $value->grandtotal_penjualan;
        }
        

        foreach ($hasil as  $value) {
           
            $kategori[] = $value->kategori;
            $penjualan[] = (int)$value->grandtotal_penjualan;
        }       

        

       return response()->json([
            'datakategori' => $kategori,
            'datapenjualan' => $penjualan
        ]);
        
    }


    public function grafikProduk(Request $request)
    {
        
        $results = DB::table('faktur_penjualans as fp')
                    ->join('faktur_penjualan_details as fdp','fdp.faktur_penjualan_id','=','fp.id')                    
                    ->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')  
                    ->join('products as p','fdp.product_id','=','p.id')                    
                    ->where('fp.deleted_at','=',null);

        if ($request->year) {
            $res=$results->whereYear('fp.tanggal',$request->year);       
        }else{
            $res=$results;
        }

        if ($request->produk) {
            $productFilter = $res->where('fdp.product_id',$request->produk);
        }else{
            $productFilter = $res;
        }
        

        $hasil = $productFilter
                    ->groupBy('fdp.product_id')
                    ->groupBy(DB::raw("DATE_FORMAT(fp.tanggal, '%m-%Y')"))
                    ->select(
                        'p.nama','p.id',
                        DB::raw("DATE_FORMAT(fp.tanggal, '%m') as tanggal_penjualan"),
                        DB::raw("sum(fdp.qty) as stok_produk")
                    )                  
                    ->get(); 
        
        
        
        foreach ($hasil as $key => $value) {
            $data[(int)$value->tanggal_penjualan] = [
                'stok' => (int)$value->stok_produk
            ];
        }

        for ($i=0; $i <= 12; $i++) { 
            if ($i==0) {
                $stok[] = 0;
            }else{
                if (!empty($data[$i])) {
                    $stok[] = $data[$i]['stok'];
                }else{
                    $stok[] = 0;
                }
            }            
        }


        for ($i = 0; $i <=12; $i++) {
            if ($i==0) {
                $months[] = 0;
            }else{ 
                $months[] = date('F', mktime(0,0,0,$i));
            }            
        }

        
        return response()->json([
            'stok' => $stok,
            'bulan' => $months
        ]);
    }


    public function grafikPenjualanProdukTerbaik(Request $request)
    {
        $results = DB::table('faktur_penjualans as fp')
                    ->join('faktur_penjualan_details as fdp','fdp.faktur_penjualan_id','=','fp.id')                    
                    ->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')  
                    ->join('products as p','fdp.product_id','=','p.id')                    
                    ->where('fp.deleted_at','=',null);

        if ($request->year) {
            $res=$results->whereYear('fp.tanggal',$request->year);       
        }else{
            $res=$results;
        }

        if ($request->bulan !== 'All') {
            $bulan = $res->whereMonth('fp.tanggal',$request->bulan)
                    ->groupBy(DB::raw("DATE_FORMAT(fp.tanggal, '%m-%Y')"));
        }else{
            $bulan = $res;
        }

        $hasil = $bulan
                ->groupBy('fdp.product_id')             
                ->select(
                    'p.nama','p.id','p.kode',
                    DB::raw("DATE_FORMAT(fp.tanggal, '%m') as tanggal_penjualan"),
                    DB::raw("sum(fdp.qty) as stok_produk")
                )                  
                ->get(); 
        
        $count = count($hasil);

        $tmp = null;
        $nama_produk = [];
        $stok_produk=[];
        
       
        // dd($hasil);  

        if ($count > 0) {
            for ($i=0; $i < $count-1 ; $i++) { 
                for ($j=$i+1; $j < $count ; $j++) { 
                    if ($hasil[$i]->stok_produk < $hasil[$j]->stok_produk) {
                        $tmp = $hasil[$i];
                        $hasil[$i] = $hasil[$j];
                        $hasil[$j] = $tmp;
                    }
                }
            }

            dd($hasil);
            
    
            for ($k=0; $k < 10; $k++) { 
                $nama_produk[] = $hasil[$k]->nama;
                $stok_produk[] = $hasil[$k]->stok_produk;
            }

        }

        
      

        return response()->json([
            'nama_produk' => $nama_produk,
            'stok' => $stok_produk
        ]);
       
    }
}
