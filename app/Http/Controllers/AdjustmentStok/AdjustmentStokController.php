<?php

namespace App\Http\Controllers\AdjustmentStok;

use App\Http\Controllers\Controller;
use App\Imports\ProductExpiredImport;
use App\Imports\ProductImport;
use App\Models\AdjustmentStok;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AdjustmentStokController extends Controller
{
    public function index()
    {
        $title = "Adjusment Stok";        
        return view('adjustmentstok.index',compact('title'));
    }

    public function expired()
    {
        $title = "Adjustment Stok Expired";
        $adjusment = AdjustmentStok::with(['product'])->where('jenis','expired')->orderByDesc('id');

        if (request()->ajax()) {
            return DataTables::of($adjusment)
                ->addIndexColumn()                               
                ->addColumn('kode_ajs', function (AdjustmentStok $pb) {
                    return $pb->kode;
                })
                ->addColumn('kode_produk', function (AdjustmentStok $pb) {
                    return $pb->product->kode;
                })
                ->addColumn('produk', function (AdjustmentStok $pb) {
                    return $pb->product->nama;
                })
                ->addColumn('qty', function (AdjustmentStok $pb) {
                    return $pb->qty;
                })          
                ->addColumn('action', function ($row) {                    
                    $showUrl = route('konversisatuan.show', ['konversisatuan' => $row->id]);                    
                    $id = $row->id;
                    $status = $row->status_pb_id;
                    return view('konversi.modal._form-action', compact('showUrl','id'));
                })                      
                ->make(true);
        }

        return view('adjustmentstok.expired.index', compact('title','adjusment'));
    }

    public function nonexpired()
    {
        $title = "Adjustment Stok Non Expired";
        $adjusment = AdjustmentStok::with(['product'])->where('jenis','nonexpired')->orderByDesc('id');        

        if (request()->ajax()) {
            return DataTables::of($adjusment)
                ->addIndexColumn()               
                ->addColumn('kode_ajs', function (AdjustmentStok $pb) {
                    return $pb->kode;
                })
                ->addColumn('kode_produk', function (AdjustmentStok $pb) {
                    return $pb->product->kode;
                })
                ->addColumn('produk', function (AdjustmentStok $pb) {
                    return $pb->product->nama;
                })
                ->addColumn('qty', function (AdjustmentStok $pb) {
                    return $pb->qty;
                })          
            ->addColumn('action', function ($row) {                    
                    $showUrl = route('konversisatuan.show', ['konversisatuan' => $row->id]);                    
                    $id = $row->id;
                    $status = $row->status_pb_id;
                    return view('konversi.modal._form-action', compact('showUrl','id'));
                })
                      
                ->make(true);
        }

        return view('adjustmentstok.nonexpired.index', compact('title','adjusment'));
        
    }

    public function importNonExpired(Request $request)
    {        
        Excel::import(new ProductImport, $request->file('file_import'));        

        return back();
    }

    public function importExpired(Request $request)
    {        
        Excel::import(new ProductExpiredImport, $request->file('file_import'));        

        return back();
    }


}
