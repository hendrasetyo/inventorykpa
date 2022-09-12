<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPembayaranHutangExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    { 
        $title = 'Laporan Pembayaran Hutang Detail';        
        
        $tgl1 = Carbon::parse($this->data['tgl1'])->format('Y-m-d');
        $tgl2 = Carbon::parse($this->data['tgl2'])->format('Y-m-d');                

        $pembayaran = DB::table('Hutangs as h')
                    ->join('pesanan_pembelians as pp','h.pesanan_pembelian_id','=','pp.id')                    
                    ->join('penerimaan_barangs as pb','h.penerimaan_barang_id','=','pb.id')                   
                    ->where('h.tanggal','>=',$tgl1)
                    ->where('h.tanggal','<=',$tgl2);
                    
        
        if ($this->data['supplier'] == 'all') {  

            $customerfilter = $pembayaran->join('suppliers as s','h.supplier_id','=','s.id');

            if ($this->data['no_faktur'] <> null) {
                
                $filter =  $customerfilter->join('faktur_pembelians as fb','h.faktur_pembelian_id','=','fb.id')
                                            ->where('fb.kode','=', $this->data['no_faktur']);
            }else{
                
                $filter =  $customerfilter->join('faktur_pembelians as fb','h.faktur_pembelian_id','=','fb.id');
                                          
            }
        }else{
            $customerfilter = $pembayaran->join('suppliers as s','h.supplier_id','=','s.id')
                                         ->where('s.id','=',$this->data['supplier']);

            if ($this->data['no_faktur'] <> null) {
                $filter =  $customerfilter->join('faktur_pembelians as fb','h.faktur_pembelian_id','=','fb.id')
                                        ->where('fb.kode','=',$this->data['no_faktur']); 
            }else{
                $filter =  $customerfilter->join('faktur_pembelians as fb','h.faktur_pembelian_id','=','fb.id');
                                          
            }
        }

        $datafilter = $filter->select('s.nama as nama_supplier','pp.kode as kode_pp','pb.kode as kode_pb','fb.kode as kode_fp'
                                ,'h.*')->get();

        if (count($datafilter) <= 0) {
                return redirect()->back()->with('status_danger', 'Data tidak ditemukan atau belum melakukan pembayaran');
        }

      
        
        return view('laporan.pembayaran.export.exportPembayaranHutang',[
            'title' => $title,
            'hutang' => $datafilter,  
        ]);
    }


}
