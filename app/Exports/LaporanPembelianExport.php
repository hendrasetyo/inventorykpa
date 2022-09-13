<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPembelianExport implements FromView
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

        $filter = $customerfilter->select('fp.*','pb.kode as kode_SJ','pp.kode as kode_SP','s.nama as nama_supplier','u.name as nama_pembuat')->get();                                        
                
        if (count($filter) <= 0) {
            return redirect()->back()->with('status_danger', 'Data tidak ditemukan');
        }        

        return view('laporan.pembelian.export.exportPembelian',[
            'pembelian' => $filter,                        
        ]);            


    }
}
