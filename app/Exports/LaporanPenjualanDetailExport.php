<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPenjualanDetailExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {

                   
        $tgl1 = Carbon::parse($this->data['tgl1'])->format('Y-m-d');
        $tgl2 = Carbon::parse($this->data['tgl2'])->format('Y-m-d');                
        $penjualan = DB::table('faktur_penjualans as fp')
                    ->join('pengiriman_barangs as pb','fp.pengiriman_barang_id','=','pb.id')
                    ->join('faktur_penjualan_details as fpb','fpb.faktur_penjualan_id','=','fp.id')
                    ->join('users as u','fp.created_by','=','u.id')
                    ->join('products as p','p.id','=','fpb.product_id')
                    // ->join('users as us','fpb.created_by','=','us.id')
                    ->where('fp.tanggal','>=',$tgl1)
                    ->where('fp.tanggal','<=',$tgl2);  
                    
        // dd($penjualan->get());

        if ($this->data['customer'] == 'all') {            

            $customerfilter = $penjualan->join('customers as cs','fp.customer_id','=','cs.id');

            if ($this->data['sales'] == 'all') {
                $salesfilter = $customerfilter->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                              ->join('sales as s','pp.sales_id','=','s.id');                
                              
            }else{
                $salesfilter = $customerfilter->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                              ->join('sales as s','pp.sales_id','=','s.id')
                              ->where('pp.sales_id','=',$this->data['sales']);                
            }
           
            
        }else{
            $customerfilter = $penjualan->join('customers as cs','fp.customer_id','=','cs.id')
                              ->where('fp.customer_id','=',$this->data['customer']);

            if ($this->data['sales'] == 'all') {  
                $salesfilter = $customerfilter->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                            ->join('sales as s','pp.sales_id','=','s.id');
            }else{
                $salesfilter = $customerfilter->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                                ->join('sales as s','pp.sales_id','=','s.id')
                                ->where('pp.sales_id','=',$this->data['sales']);                
            }         

        }
        $filter = $salesfilter->select('fp.*','fpb.qty as qty_det','fpb.satuan as satuan_det','fpb.hargajual as hargajual_det'
                                        ,'fpb.diskon_persen as dikson_persen_det','fpb.diskon_rp as diskon_rp_det','fpb.subtotal as subtotal_det'
                                        ,'fpb.total as total_det','fpb.total_diskon as total_diskon_det','fpb.ongkir as ongkir_det','fpb.keterangan as keterangan_det' 
                                        ,'pb.kode as kode_SJ','pp.kode as kode_SP'
                                        ,'s.nama as nama_sales','u.name as nama_pembuat'
                                        ,'cs.nama as nama_customer','p.nama as nama_produk')->get();                                        
                
        if (count($filter) <= 0) {
            return redirect()->back()->with('status_danger', 'Data tidak ditemukan');
        }
        
                
        // dd($filter);
        return view('laporan.penjualan.export.exportpenjualandetail',[
            'penjualan' => $filter,            
        ]);            
        
    }
}
