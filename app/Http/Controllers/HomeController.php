<?php

namespace App\Http\Controllers;

use App\Models\FakturPenjualan;
use App\Models\Kategoripesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {        
        $kategori = Kategoripesanan::get();
        $months =  [];
        for ($i = 1; $i <=12; $i++) {
            $months[] = [
                'bulan' => date('F', mktime(0,0,0,$i)),
                'id' => $i
            ];
        }

       

        return view('home',[
            'kategori' => $kategori,
            'bulan' => $months
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

        if ($request->bulan == '13') {
            $bulan = $kategori;
        }elseif ($request->bulan !== '13' && $request->bulan !== null) {
            $bulan = $kategori->whereMonth('fp.tanggal',$request->bulan);
        }else{
            $bulan = $kategori;
        }

        if ($request->tipe == 'bulan') {
            $tipe = $bulan->groupBy(DB::raw("DATE_FORMAT(fp.tanggal, '%d-%m-%Y')"))
                    ->select(
                        DB::raw("DATE_FORMAT(fp.tanggal, '%d') as tanggal_penjualan"),
                        DB::raw("sum(fp.grandtotal) as grandtotal_penjualan")
                    );     
        }else{
            
            $tipe = $bulan->groupBy(DB::raw("DATE_FORMAT(fp.tanggal, '%m-%Y')"))
                    ->select(
                        DB::raw("DATE_FORMAT(fp.tanggal, '%m') as tanggal_penjualan"),
                        DB::raw("sum(fp.grandtotal) as grandtotal_penjualan")
                    ); 
        }
        
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
            $penjualan[] = $value->grandtotal_penjualan;
        }       

        

       return response()->json([
            'datakategori' => $kategori,
            'datapenjualan' => $penjualan
        ]);
        
    }


    public function grafikProduk(Request $request)
    {
        return view();
    }
}
