<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Kategoripesanan;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerformaSalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:performasales-list');
    }

    public function index()
    {
        $title = 'Performa Sales';
        $sales = Sales::get();

        return view('sales.performasales.index',compact('sales','title'));
    }

    public function dataperformasales(Request $request)
    {
       $results = DB::table('faktur_penjualans as fp')
                    ->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                    ->join('kategoripesanans as kp','pp.kategoripesanan_id','=','kp.id')
                    ->join('sales as s','pp.sales_id','=','s.id')
                    ->where('fp.deleted_at','=',null);

        if ($request->year) {
            $res=$results->whereYear('fp.tanggal',$request->year);       
        }else{
            $res=$results;
        }

        if ($request->month) {
            $res=$results->whereMonth('fp.tanggal',$request->month);       
        }else{
            $res=$results;
        }

        $hasil = $res->groupBy('pp.sales_id')
        ->select(
            DB::raw("DATE_FORMAT(fp.tanggal,'%M') as tanggal"),
           's.nama','s.id',
            DB::raw("sum(fp.grandtotal) as grandtotal_penjualan")
        )->get();


        $sales = Sales::get();
        $dataSales = [];

        foreach ($sales as $value) {
            foreach ($hasil as $res) {
                 if ($value->id == $res->id) {
                    $dataSales[] = [
                        'id' => $value->id,
                        'bulan' =>$res->tanggal,
                        'nama' => $res->nama,
                        'laba' => number_format($res->grandtotal_penjualan, 0, ',', '.'),
                        'persen' => (int) ($res->grandtotal_penjualan/575000000 * 100)
                    ]; 
                 }
            }    
        }

        return response()->json([ 
            'sales' => $dataSales
        ]);
    }

    public function grafikPerformaSales(Request $request)
    {

        
        $results = DB::table('faktur_penjualans as fp')
                  ->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                  ->join('kategoripesanans as kp','pp.kategoripesanan_id','=','kp.id')
                  ->join('sales as s','pp.sales_id','=','s.id')
                  ->where('fp.deleted_at','=',null);
        
        if ($request->year) {
            $res=$results->whereYear('fp.tanggal',$request->year);       
        }else{
            $res=$results;
        }
        
       $hasil= $res->groupBy('pp.sales_id')                 
        ->select(
        's.id','s.nama as nama_sales','kp.nama as nama_kategori',
        DB::raw("sum(fp.grandtotal) as grandtotal_penjualan")
        )->get();


        

        foreach ($hasil as $key => $value) {
            $sales[] =  $value->nama_sales ;
            $penjualan []  = $value->grandtotal_penjualan;
        }
        
        

        return response()->json([
            'sales' => $sales,
            'penjualan' => $penjualan
        ]);

        
    }

    // =====================================================================================================================================
    // GRAFIK UNTUK DETAIL SALES 
    // =====================================================================================================================================


    public function performasalesdetail($id)
    {
        $title = 'Detail Performa Sales';
        $kategori = Kategoripesanan::get();

        return view('sales.performasales.detailperforma.index',[
            'sales_id' => $id,
            'title' => $title,
            'kategori' => $kategori
        ]);


    }


    public function grafikperformasalesdetail(Request $request)
    {
         $results = DB::table('faktur_penjualans as fp')
                ->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                ->where('fp.deleted_at','=',null)
                ->orderBy('fp.tanggal')
                ->where('pp.sales_id',$request->id);

                 

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


    public function performasalesCustomer(Request $request)
    {
        $results = DB::table('faktur_penjualans as fp')
                ->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                ->join('customers as c','pp.customer_id','=','c.id')
                ->where('fp.deleted_at','=',null)                
                ->where('pp.sales_id',$request->id);

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
        $tipe = $bulan->groupBy('pp.customer_id')
                ->select(
                    'c.nama as nama_customer',                  
                    DB::raw("sum(fp.grandtotal) as grandtotal_penjualan")
                ); 

        
       $hasil= $tipe->get();

      foreach ($hasil as $value) {
            $customer [] = $value->nama_customer;
            $laba[] = $value->grandtotal_penjualan;
      }



        return response()->json([
            'laba' => $laba,
            'customer' => $customer
        ]);
         
    }


}
