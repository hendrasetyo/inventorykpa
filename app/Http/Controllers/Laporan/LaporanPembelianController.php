<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\LaporanPembelianExport;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPembelianController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:laporanpembelian-list');        
        // $this->middleware('permission:laporanstokkartu-list', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:laporanstokexp-list', ['only' => ['destroy']]);
    }


    public function index()
    {        
        $title = "Laporan Pembelian";
        return view('laporan.pembelian.index', compact('title'));
        
    }

    public function filterPembelian()
    {                    
        $title = "Laporan Pembelian";
        $supplier = Supplier::with('namakota')->select('id','nama','kota')->get();        

        return view('laporan.pembelian.laporanpembelian.filterPembelian', [
            'supplier' => $supplier,        
            'title' => $title
        ]);

    }

    public function filterPembelianDetail()
    {
        $title = "Laporan Pembelian Detail";
        $supplier = Supplier::with('namakota')->select('id','nama','kota')->get();      
        
        return view('laporan.pembelian.laporanpembeliandetail.filterPembelian', [
            'supplier' => $supplier,        
            'title' => $title
        ]);
        
    }

    public function filterDataPembelian(Request $request)
    {
        $title = 'Laporan Pembelian';
        $data = $request->all();
        $tgl1 = Carbon::parse($data['tgl1'])->format('Y-m-d');
        $tgl2 = Carbon::parse($data['tgl2'])->format('Y-m-d');                
        $penjualan = DB::table('faktur_pembelians as fp')        
                    ->join('penerimaan_barangs as pb','fp.penerimaan_barang_id','=','pb.id')
                    ->join('pesanan_pembelians as pp','fp.pesanan_pembelian_id','=','pp.id')
                    ->join('users as u','fp.created_by','=','u.id')
                    ->where('fp.tanggal','>=',$tgl1)
                    ->where('fp.tanggal','<=',$tgl2);  
        
        
    
        // dd($penjualan->get());

        if ($data['supplier'] == 'all') {            

            $customerfilter = $penjualan->join('suppliers as s','fp.supplier_id','=','s.id');                           
        }else{
            $customerfilter = $penjualan->join('supplier as s','fp.supplier_id','=','s.id')
                              ->where('fp.supplier_id','=',$data['supplier']);                 

        }

        $filter = $customerfilter->select('fp.*','pb.kode as kode_SJ','pp.kode as kode_SP','s.nama as nama_supplier','u.name as nama_pembuat')->get();                                        
                
        if (count($filter) <= 0) {
            return redirect()->back()->with('status_danger', 'Data tidak ditemukan');
        }        

        return view('laporan.pembelian.laporanpembelian.filterPembelianResult',[
            'pembelian' => $filter,
            'title' => $title,
            'form' => $data
        ]);            


    }
    public function exportPembelian(Request $request)
    {
        $data = $request->all();        
        $now = Carbon::parse(now())->format('Y-m-d');
        return Excel::download(new LaporanPembelianExport($data), 'laporanpembelian-'.$now.'.xlsx');
    }


}
