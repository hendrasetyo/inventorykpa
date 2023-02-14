<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPenjualanExport implements FromView
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
                    ->join('users as u','fp.created_by','=','u.id')
                    ->join('pesanan_penjualans as pp','fp.pesanan_penjualan_id','=','pp.id')
                    ->join('sales as s','pp.sales_id','=','s.id')
                    ->join('customers as cs','fp.customer_id','=','cs.id')            
                    ->where('fp.deleted_at',null);
                    
        
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
                                ->where('fp.tanggal','<=',$tgl2);
            }
        }else{
            $tanggalFilter = $penjualan;
        }
        

        if ($this->data['customer'] == 'all') {            
            $customerfilter = $tanggalFilter;                           
        }else{
            $customerfilter = $tanggalFilter->where('fp.customer_id','=',$this->data['customer']);
        }

        if ($this->data['sales'] == 'all') {
            $salesfilter = $customerfilter;                                          
        }else{
            $salesfilter = $customerfilter->where('pp.sales_id','=',$this->data['sales']);                
        }

        $dataFilter = $salesfilter->orderBy('fp.tanggal','desc')->select('fp.*','pb.kode as kode_SJ','pp.kode as kode_SP','s.nama as nama_sales','u.name as nama_pembuat','cs.nama as nama_customer')->get();
        
        // return $dataFilter;
        return view('laporan.penjualan.export.exportpenjualan',[
            'penjualan' => $dataFilter
        ]);
    }
}
