<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Imports\TargetSalesImport;
use App\Models\TargetSales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class TargetSalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:targetsales-list');
        $this->middleware('permission:targetsales-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:targetsales-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:targetsales-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = 'Target Sales';
        return view('sales.targetsales.index',compact('title'));
    }

    public function import(Request $request)
    {
        Excel::import(new TargetSalesImport, $request->file('file'));

        return back();
    }

    public function datatable(Request $request)
    {
        $data = TargetSales::with('sales')->orderBy('id','desc');        
        return DataTables::of($data)
                ->addIndexColumn()                  
                ->editColumn('bulan', function ($data) {
                    $bulan = '1-'.$data->bulan.'-2023';
                    return $data->bulan ? with(new Carbon($bulan))->format('F') : '';; 
                })         
                ->editColumn('sales_id', function ($data) {
                    return $data->sales->nama; 
                })                                  
                ->editColumn('nominal', function ($data) {
                    return 'Rp.' . number_format($data->nominal, 0, ',', '.');
                })          
                ->make(true);   
    }
}
