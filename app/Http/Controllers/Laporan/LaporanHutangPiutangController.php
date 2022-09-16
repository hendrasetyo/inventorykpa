<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\LaporanHutangExport;
use App\Exports\LaporanPiutangExport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanHutangPiutangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporanhutang-list');        
    }

    public function index()
    {
        return view('laporan.hutangpiutang.index');
    }


    public function hutang()
    {
        $title = "Laporan  Hutang";
        $supplier = Supplier::with('namakota')->select('id','nama','kota')->get();

        // dd($supplier[0]);
        return view('laporan.hutangpiutang.hutang.filterHutang',[
            'supplier' =>$supplier,
            'title' => $title
        ]);
    }

    public function piutang()
    {
        $title = "Laporan Piutang";
        $customer = Customer::with('namakota')->select('id','nama','kota')->get();
        $sales = Sales::select('id','nama')->get();

        return view('laporan.hutangpiutang.piutang.filterPiutang',[
            'customer' => $customer,
            'sales' => $sales,
            'title' => $title
        ]);
    }

    public function filterHutang(Request $request)
    {
        $title = 'Laporan Hutang';
        $data = $request->all();        

        
        $tgl1 = Carbon::parse($data['tgl1'])->format('Y-m-d');
        $tgl2 = Carbon::parse($data['tgl2'])->format('Y-m-d');                

        $pembayaran = DB::table('hutangs as h')
                    ->join('pesanan_pembelians as pp','h.pesanan_pembelian_id','=','pp.id')                    
                    ->join('penerimaan_barangs as pb','h.penerimaan_barang_id','=','pb.id');               
                    

        
        if ($data['tgl1']) {            
            if (!$data['tgl2']) {
                $tanggalFilter=$pembayaran->where('h.tanggal_top','>=',$tgl1);
                                
            }else{
                $tanggalFilter=$pembayaran->where('h.tanggal_top','>=',$tgl1)
                                ->where('h.tanggal_top','<=',$tgl2);
            }
        }elseif($data['tgl2']){
            if (!$data['tgl1']) {
                $tanggalFilter=$pembayaran->where('h.tanggal_top','<=',$tgl2);
            }else{
                $tanggalFilter=$pembayaran->where('h.tanggal_top','>=',$tgl1)
                                ->where('h.tanggal_top','<=',$tgl2);
            }
        }else{
            $tanggalFilter = $pembayaran;
        }
                    
        
        if ($request->supplier == 'all') {  

            $customerfilter = $tanggalFilter->join('suppliers as s','h.supplier_id','=','s.id');

            if ($request->no_faktur <> null) {                
                $filter =  $customerfilter->join('faktur_pembelians as fb','h.faktur_pembelian_id','=','fb.id')
                                            ->where('fb.kode','=',$request->no_faktur);
            }else{                
                $filter =  $customerfilter->join('faktur_pembelians as fb','h.faktur_pembelian_id','=','fb.id');
                                          
            }

        }else{
            $customerfilter = $pembayaran->join('suppliers as s','h.supplier_id','=','s.id')
                                         ->where('s.id','=',$request->supplier);

            if ($request->no_faktur <> null) {
                $filter =  $customerfilter->join('faktur_pembelians as fb','h.faktur_pembelian_id','=','fb.id')
                                        ->where('fb.kode','=',$request->no_faktur); 
            }else{
                $filter =  $customerfilter->join('faktur_pembelians as fb','h.faktur_pembelian_id','=','fb.id');                                          
            }

        }

        $statusFilter = $filter->where('h.status','=',$data['status']);

        $datafilter = $statusFilter->select('s.nama as nama_supplier','pp.kode as kode_pp','pb.kode as kode_pb','fb.kode as kode_fp'
                                ,'h.*')->get();

        
        

        if (count($datafilter) <= 0) {
                return redirect()->back()->with('status_danger', 'Data tidak ditemukan');
        }

        return view('laporan.hutangpiutang.hutang.filterHutangResult',[
            'title' => $title,
            'hutang' => $datafilter,
            'form' => $data
        ]);

    }

    public function exportHutang(Request $request)
    {
        $data = $request->all();        
        $now = Carbon::parse(now())->format('Y-m-d');
        return Excel::download(new LaporanHutangExport($data), 'laporanhutang-'.$now.'.xlsx');
    }

    public function filterPiutang(Request $request)
    {
        $title = 'Laporan Piutang';
        $data = $request->all();        
        
        $tgl1 = Carbon::parse($data['tgl1'])->format('Y-m-d');
        $tgl2 = Carbon::parse($data['tgl2'])->format('Y-m-d');                

        $pembayaran = DB::table('piutangs as p')
                    ->join('pesanan_penjualans as pp','p.pesanan_penjualan_id','=','pp.id')                    
                    ->join('pengiriman_barangs as pb','p.pengiriman_barang_id','=','pb.id');                                    
                    

        if ($data['tgl1']) {            
            if (!$data['tgl2']) {
                $tanggalFilter=$pembayaran->where('p.tanggal_top','>=',$tgl1);
                                
            }else{
                $tanggalFilter=$pembayaran->where('p.tanggal_top','>=',$tgl1)
                                ->where('p.tanggal_top','<=',$tgl2);
            }
        }elseif($data['tgl2']){
            if (!$data['tgl1']) {
                $tanggalFilter=$pembayaran->where('p.tanggal_top','<=',$tgl2);
            }else{
                $tanggalFilter=$pembayaran->where('p.tanggal_top','>=',$tgl1)
                                ->where('p.tanggal_top','<=',$tgl2);
            }
        }else{
            $tanggalFilter = $pembayaran;
        }
        

        if ($data['customer'] == 'all') {  

            $customerfilter = $tanggalFilter->join('customers as c','p.customer_id','=','c.id');

            if ($data['no_faktur'] <> null) {                
                $filter =  $customerfilter->join('faktur_penjualans as fp','p.faktur_penjualan_id','=','fp.id')
                                            ->where('fb.kode','=',$data['no_faktur']);

                    if ($data['sales'] == 'all') {
                        $salesfilter = $filter->join('sales as s','pp.sales_id','=','s.id');                
                                        
                    }else{
                        $salesfilter = $filter->join('sales as s','pp.sales_id','=','s.id')
                                        ->where('pp.sales_id','=',$data['sales']);                
                    }
                                    
            }else{                
                $filter =  $customerfilter->join('faktur_penjualans as fp','p.faktur_penjualan_id','=','fp.id');

                if ($data['sales'] == 'all') {
                    $salesfilter = $filter->join('sales as s','pp.sales_id','=','s.id');                
                                    
                }else{
                    $salesfilter = $filter->join('sales as s','pp.sales_id','=','s.id')
                                    ->where('pp.sales_id','=',$data['sales']);                
                }
                                          
            }
        }else{
            $customerfilter = $pembayaran->join('customers as c','p.customer_id','=','c.id')
                                         ->where('c.id','=',$data['customer']);

            if ($data['no_faktur'] <> null) {
                $filter =  $customerfilter->join('faktur_penjualans as fp','p.faktur_penjualan_id','=','fp.id')
                                        ->where('fb.kode','=',$data['no_faktur']); 

                    if ($data['sales'] == 'all') {
                        $salesfilter = $filter->join('sales as s','pp.sales_id','=','s.id');                
                                        
                    }else{
                        $salesfilter = $filter->join('sales as s','pp.sales_id','=','s.id')
                                        ->where('pp.sales_id','=',$data['sales']);                
                    }
            }else{
                $filter =  $customerfilter->join('faktur_penjualans as fp','p.faktur_penjualan_id','=','fp.id');

                        if ($data['sales'] == 'all') {
                            $salesfilter = $filter->join('sales as s','pp.sales_id','=','s.id');                
                                            
                        }else{
                            $salesfilter = $filter->join('sales as s','pp.sales_id','=','s.id')
                                            ->where('pp.sales_id','=',$data['sales']);                
                        }
                                                
            }
        }


        $statusFilter = $salesfilter->where('p.status','=',$data['status']);

        $datafilter = $statusFilter->select('c.nama as nama_customer','pp.kode as kode_pp','pb.kode as kode_pb','fp.kode as kode_fp','p.*','s.nama as nama_sales')->get();

        if (count($datafilter) <= 0) {
                return redirect()->back()->with('status_danger', 'Data tidak ditemukan atau belum melakukan pembayaran');
        }
        

        return view('laporan.hutangpiutang.piutang.filterPiutangResult',[
            'title' => $title,
            'hutang' => $datafilter,
            'form' => $data
        ]);
    }

    public function exportPiutang(Request $request)
    {
        $data = $request->all();        
        $now = Carbon::parse(now())->format('Y-m-d');
        return Excel::download(new LaporanPiutangExport($data), 'laporanpiutang-'.$now.'.xlsx');
    }

}
