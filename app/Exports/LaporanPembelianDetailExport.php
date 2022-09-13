<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPembelianDetailExport implements FromView
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
        $penjualan = DB::table('faktur_pembelians as fp')        
                    ->join('penerimaan_barangs as pb','fp.penerimaan_barang_id','=','pb.id')
                    ->join('pesanan_pembelians as pp','fp.pesanan_pembelian_id','=','pp.id')
                    ->join('faktur_pembelian_details as fpb','fpb.faktur_pembelian_id','=','fp.id')
                    ->join('products as p','fpb.product_id','=','p.id')
                    ->join('users as u','fp.created_by','=','u.id')
                    ->where('fp.tanggal','>=',$tgl1)
                    ->where('fp.tanggal','<=',$tgl2); 

                  
        
        
    
        // dd($penjualan->get());

        if ($this->data['supplier'] == 'all') {            

            $customerfilter = $penjualan->join('suppliers as s','fp.supplier_id','=','s.id');                           
        }else{
            $customerfilter = $penjualan->join('supplier as s','fp.supplier_id','=','s.id')
                              ->where('fp.supplier_id','=',$this->data['supplier']);                 

        }

        $filter = $customerfilter->select('fp.*','pb.kode as kode_SJ'
                                ,'pp.kode as kode_SP'
                                ,'s.nama as nama_supplier'
                                ,'u.name as nama_pembuat',
                                'fpb.qty as qty_produk','fpb.satuan as satuan_produk'
                                ,'fpb.hargabeli as hargabeli_produk','fpb.diskon_persen as diskon_persen_produk',
                                'fpb.diskon_rp as diskon_rp_produk','fpb.subtotal as subtotal_produk',
                                'fpb.total_diskon as total_diskon_produk',
                                'fpb.total as total_produk','fpb.ongkir as ongkir_produk',
                                'fpb.keterangan as keterangan_produk','p.nama as nama_produk'
                                )->get();      
                
        if (count($filter) <= 0) {
            return redirect()->back()->with('status_danger', 'Data tidak ditemukan');
        }       
        

        return view('laporan.pembelian.export.exportPembeliandetail',[
            'pembelian' => $filter,                        
        ]);            


    }
}
