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
                    ->join('users as u','fp.created_by','=','u.id');
                    
                        
                if ($this->data['tgl1']) {            
                    if (!$this->data['tgl2']) {
                        $tanggalFilter=$penjualan->where('fp.tanggal','>=',$tgl1);
                                        
                    }else{
                        $tanggalFilter=$penjualan->where('fp.tanggal','>=',$tgl1)
                                        ->where('fp.tanggal','<=',$tgl2);
                    }
                }elseif($this->data['tgl2']){
                    if (!$this->data['tgl1']) {
                        $tanggalFilter=$penjualan->where('fp.tanggal','<=',$tgl2);
                    }else{
                        $tanggalFilter=$penjualan->where('fp.tanggal','>=',$tgl1)
                                        ->where('fp.tanggal_top','<=',$tgl2);
                    }
                }else{
                    $tanggalFilter = $penjualan;
                }
                                    

                if ($this->data['customer'] == 'all') {            
                $customerfilter = $tanggalFilter->join('customers as cs','fp.customer_id','=','cs.id');                                  
                }else{
                $customerfilter = $penjualan->join('customers as cs','fp.customer_id','=','cs.id')
                                ->where('fp.customer_id','=',$this->data['customer']);     
                }

                if ($this->data['sales'] == 'all') {
                $salesfilter = $customerfilter->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                            ->join('sales as s','pp.sales_id','=','s.id');                                          
                }else{
                $salesfilter = $customerfilter->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                            ->join('sales as s','pp.sales_id','=','s.id')
                            ->where('pp.sales_id','=',$this->data['sales']);                
                }

                if ($this->data['produk'] == 'all') {
                $produkfilter = $salesfilter ->join('products as p','p.id','=','fpb.product_id');            
                } else {
                $produkfilter = $salesfilter ->join('products as p','p.id','=','fpb.product_id')
                                            ->where('p.id','=',$this->data['produk']);
                }


                if ($this->data['merk'] == 'all') {
                $merkfilter  = $produkfilter->join('merks as m','p.merk_id','=','m.id');
                } else {
                $merkfilter  = $produkfilter->join('merks as m','p.merk_id','=','m.id')
                                ->where('m.id','=',$this->data['merk']);
                }


                $filter = $merkfilter->orderBy('fp.tanggal','desc')->select('fp.*','fpb.qty as qty_det','fpb.satuan as satuan_det','fpb.hargajual as hargajual_det'
                                            ,'fpb.diskon_persen as dikson_persen_det','fpb.diskon_rp as diskon_rp_det','fpb.subtotal as subtotal_det'
                                            ,'fpb.total as total_det','fpb.total_diskon as total_diskon_det','fpb.ongkir as ongkir_det','fpb.keterangan as keterangan_det' 
                                            ,'pb.kode as kode_SJ','pp.kode as kode_SP'
                                            ,'s.nama as nama_sales','u.name as nama_pembuat'
                                            ,'cs.nama as nama_customer','p.nama as nama_produk','m.nama as nama_merk','p.kode as kode_produk')->get();                                        

                                            
        // dd($filter);
            return view('laporan.penjualan.export.exportpenjualandetail',[
                'penjualan' => $filter,            
            ]);            
        
    }
}
