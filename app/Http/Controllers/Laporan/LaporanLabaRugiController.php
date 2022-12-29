<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\FakturPenjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanLabaRugiController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:laporanlabarugi-list');
        $this->middleware('permission:laporanlabarugi-print', ['only' => ['print']]);
        $this->middleware('permission:laporanlabarugi-show', ['only' => ['show']]);
      
    }

    public function index()
    {
        $title = "Laporan Laba & Rugi";
        $customer = Customer::with('namakota')->get();

        return view('laporan.labarugi.index',compact('title','customer'));
    }


    public function datatable(Request $request)
    {

        $fakturpenjualan = FakturPenjualan::with(['customers',  'statusFJ', 'so', 'sj'])->orderByDesc('id');

        if ($request->tanggalMulai) {
           $fakturpenjualan->where('tanggal','>',$request->tanggalMulai);
        }

        if ($request->tanggalSelesai) {
            $fakturpenjualan->where('tanggal','<',$request->tanggalSelesai);
        }

        if ($request->customer !== 'all') {
            $fakturpenjualan->where('customer_id',$request->customer);
        }

        if (request()->ajax()) {
            return DataTables::of($fakturpenjualan)
                ->addIndexColumn()
                ->addColumn('customer', function (FakturPenjualan $sj) {
                    return $sj->customers->nama;
                })
                ->addColumn('kode_so', function (FakturPenjualan $sj) {
                    return $sj->so->kode;
                })
                ->addColumn('kode_sj', function (FakturPenjualan $sj) {
                    return $sj->sj->kode;
                })
                ->editColumn('tanggal', function (FakturPenjualan $sj) {
                    return $sj->tanggal ? with(new Carbon($sj->tanggal))->format('d-m-Y') : '';
                })
                ->editColumn('no_kpa', function (FakturPenjualan $sj) {
                    return $sj->no_kpa;
                })
                ->addColumn('action', function ($row) {
                    $show = route('fakturpenjualan.labarugi.show', ['fakturpenjualan' => $row->id]);
                    return view('laporan.labarugi.partial._form-action', compact('show'));
                })
                ->make(true);
         }
    }

    public function print(Request $request)
    {
        
    }
       
}
