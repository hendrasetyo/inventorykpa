<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Kategoripesanan;
use App\Models\Sales;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PerformaSalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:performasales-list');
    }

    public function index()
    {
        $title = 'Performa Sales';
        $kategori = Kategoripesanan::get();
        $sales = Sales::get();

        $bulan =  [];
        for ($i = 1; $i <=12; $i++) {
            $databulan = '1-'.$i.'-2023';
            $bulan[] = [
                'nama' => Carbon::parse($databulan)->format('F') ,
                'id' => $i
            ];         
        }


        return view('sales.performasales.index',compact('sales','title','kategori','bulan'));
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
           's.nama','s.id','s.hp',
            DB::raw("sum(fp.grandtotal) as grandtotal_penjualan"),
            DB::raw("sum(fp.ppn) as total_ppn"),
            DB::raw("sum(fp.total_cn) as total_cn")

        )->get();


        $sales = Sales::with('user')->get();
        $dataSales = [];

        foreach ($sales as $value) {
            foreach ($hasil as $res) {
                $dataOmset = $res->grandtotal_penjualan - $res->total_cn - $res->total_ppn;
                 if ($value->id == $res->id) {
                    $dataSales[] = [
                        'id' => $value->id,
                        'bulan' =>$res->tanggal,
                        'user' => $value->user,
                        'hp' => $res->hp,
                        'nama' => $res->nama,
                        'laba' => number_format($dataOmset,0, ',', '.'),
                        'persen' => (int) ($dataOmset/575000000 * 100),
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

        if ($request->kategori == 'All') {
            $kategori = $res;
        }else{
            $kategori = $res->where('pp.kategoripesanan_id',$request->kategori);
        }

        if ($request->bulan == 'All') {
            $bulan = $kategori;
        }else{
            $bulan = $kategori->whereMonth('fp.tanggal',$request->bulan)
                              ->groupBy(DB::raw("DATE_FORMAT(fp.tanggal, '%m-%Y')"));
        }
        
        $hasil= $bulan->groupBy('pp.sales_id')                 
                            ->select(
                                    's.id','s.nama as nama_sales','kp.nama as nama_kategori',
                                    DB::raw("sum(fp.grandtotal) as grandtotal_penjualan"),
                                    DB::raw("sum(fp.ppn) as total_ppn"),
                                    DB::raw("sum(fp.total_cn) as total_cn")
                            )->get();
                             
        $sales = [];
        $penjualan = [];

        $count = count($hasil);

        if ($count > 0) {
            foreach ($hasil as $key => $value) {
                $sales[] =  $value->nama_sales ;
                $penjualan []  = $value->grandtotal_penjualan - $value->total_ppn - $value->total_cn;
            }
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

        for ($i = 1; $i <=12; $i++) {
            $databulan = '1-'.$i.'-2023';
            $months[] = [
                'nama' => Carbon::parse($databulan)->format('F') ,
                'id' => $i
            ];         
        }

        $sales = Sales::where('id',$id)->first();
        

        return view('sales.performasales.detailperforma.index',[
            'sales_id' => $id,
            'title' => $title,
            'kategori' => $kategori,
            'bulan' => $months,
            'sales' => $sales
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
                    DB::raw("sum(fp.grandtotal) as grandtotal_penjualan"),
                    DB::raw("sum(fp.ppn) as total_ppn"),
                    DB::raw("sum(fp.total_cn) as total_cn")
                );         
        
        $hasil= $tipe->get();                        
        $laba = array();  
        $data=[]; 
                        
        foreach ($hasil as $key => $value) {
            $data[(int)$value->tanggal_penjualan] = [
                'grandtotal' => (int) ( $value->grandtotal_penjualan - $value->total_ppn - $value->total_cn)
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

        for ($i = 0; $i <= 12; $i++) {
            $databulan = '1-'.$i.'-2023';
            if ($i==0) {
                $months[]= [0];
            }else{
                $months[] = [
                    Carbon::parse($databulan)->format('F') 
                ]; 
            }
                   
        }

        return response()->json([
            'laba' => $laba,
            'bulan' => $months
        ]);
    }


    public function datatableCustomer(Request $request)
    {
          $results = DB::table('faktur_penjualans as fp')
                    ->join('faktur_penjualan_details as fdp','fdp.faktur_penjualan_id','=','fp.id')                    
                    ->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')        
                    ->join('customers as c','fp.customer_id','=','c.id')           
                    ->where('fp.deleted_at','=',null)
                    ->where('pp.sales_id',$request->sales_id);

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

        if ($request->kategori !== 'All') {
            $kategori = $bulan->where('pp.kategoripesanan_id',$request->kategori);
        }else{
            $kategori = $bulan;
        }
        
        $hasil = $kategori
                ->groupBy('pp.customer_id')             
                ->select(     
                    'c.nama','c.id',              
                    DB::raw("DATE_FORMAT(fp.tanggal, '%m') as tanggal_penjualan"),
                    DB::raw("DATE_FORMAT(fp.tanggal, '%Y') as tahun_penjualan"),
                    DB::raw("sum(fdp.qty) as stok_produk"),
                    DB::raw("sum(fdp.total) as total_penjualan"),                    
                    DB::raw("sum(fp.total_cn) as total_cn")      
                )                  
                ->get(); 

        $count = count($hasil);
        $tmp = null;
        
        if ($count > 0) {            
            for ($i=0; $i < $count-1 ; $i++) { 
                for ($j=$i+1; $j < $count ; $j++) { 
                    if (($hasil[$i]->total_penjualan - $hasil[$i]->total_cn) < ($hasil[$j]->total_penjualan - $hasil[$j]->total_cn) ) {
                        $tmp = $hasil[$i];
                        $hasil[$i] = $hasil[$j];
                        $hasil[$j] = $tmp;
                    }
                }
            }       
        }

        $data = $hasil;

        return DataTables::of($data)
                        ->addIndexColumn() 
                        ->editColumn('tanggal', function ($data) {
                           return $data->tanggal_penjualan . '-'. $data->tahun_penjualan; 
                        })                        
                        ->editColumn('total', function ($data) {
                            return 'Rp.' . number_format($data->total_penjualan - $data->total_cn, 0, ',', '.');
                        })        
                        ->addColumn('action', function ($data) {
                            $customer_id =  $data->id;
                            return view('sales.performasales.detailperforma.partial.button',compact('customer_id'));
                        })      
                        ->make(true);         
    }

    public function datatableProduk(Request $request)
    {
        $results = DB::table('faktur_penjualans as fp')
                    ->join('faktur_penjualan_details as fdp','fdp.faktur_penjualan_id','=','fp.id')                    
                    ->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')        
                    ->join('products as p','fdp.product_id','=','p.id')           
                    ->where('fp.deleted_at','=',null)
                    ->where('pp.sales_id',$request->sales_id)
                    ->where('fp.customer_id',$request->customer_id);

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

        if ($request->kategori !== 'All') {
             $kategori = $bulan->where('pp.kategoripesanan_id',$request->kategori);
        }else{
            $kategori = $bulan;
        }

        $hasil = $kategori
            ->groupBy('fdp.product_id')             
            ->select(     
                'p.nama','p.id',              
                DB::raw("DATE_FORMAT(fp.tanggal, '%m') as tanggal_penjualan"),
                DB::raw("DATE_FORMAT(fp.tanggal, '%Y') as tahun_penjualan"),
                DB::raw("sum(fdp.qty) as stok_produk"),
                DB::raw("sum(fdp.total) as total_penjualan"),
                DB::raw("sum(fp.total_cn) as total_cn")
            )                  
            ->get(); 

        $count = count($hasil);
        $tmp = null;

        if ($count > 0) {            
        for ($i=0; $i < $count-1 ; $i++) { 
            for ($j=$i+1; $j < $count ; $j++) { 
                if (($hasil[$i]->total_penjualan - $hasil[$i]->total_cn) < ($hasil[$j]->total_penjualan - $hasil[$j]->total_cn) ) {
                    $tmp = $hasil[$i];
                    $hasil[$i] = $hasil[$j];
                    $hasil[$j] = $tmp;
                }
            }
        }       
        }

        $data = $hasil;

        return DataTables::of($data)
                    ->addIndexColumn() 
                    ->editColumn('tanggal', function ($data) {
                    return $data->tanggal_penjualan . '-'. $data->tahun_penjualan; 
                    })                        
                    ->editColumn('total', function ($data) {
                        return 'Rp.' . number_format($data->total_penjualan -  $data->total_cn, 0, ',', '.');
                    })        
                    ->addColumn('action', function ($data) {
                        $customer_id =  $data->id;
                        return view('sales.performasales.detailperforma.partial.button',compact('customer_id'));
                    })      
                    ->make(true);  
    }
}
