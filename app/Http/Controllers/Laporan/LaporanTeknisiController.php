<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\KunjunganTeknisi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanTeknisiController extends Controller
{
    public function index()
    {
        $title = "Laporan Kunjungan Sales";
        $sales = User::whereNotNull('sales_id')->get();
        // dd($sales);
       
        return view('laporan.sales.index',compact('title','sales'));
    }


    public function datatable(Request $request)
    {
        $sales = KunjunganTeknisi::with('user');

        if ($request->tanggalMulai) {
           $sales->where('tanggal','>=',$request->tanggalMulai);
        }

        if ($request->tanggalSelesai) {
            $sales->where('tanggal','<=',$request->tanggalSelesai);
        }

        if ($request->sales !== 'all') {
            $sales->where('user_id',$request->sales);
        }

        $datasales = $sales->orderBy('id','desc');

        if (request()->ajax()) {
            return DataTables::of($datasales)
                ->addIndexColumn()
                ->editColumn('tanggal', function (KunjunganTeknisi $sj) {
                    return $sj->tanggal ? with(new Carbon($sj->tanggal))->format('d-m-Y') : '';
                })
                ->editColumn('created_at', function (KunjunganTeknisi $sj) {
                    return $sj->created_at ? with(new Carbon($sj->created_at))->format('H:i') : '';
                })
                ->editColumn('name', function (KunjunganTeknisi $sj) {
                    return $sj->user->name;
                })
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $tanggal = Carbon::parse($row->tanggal)->format('d-F-Y');
                    return view('laporan.sales.partial._form-action', [
                        'id' => $id,
                        'tanggal' => $tanggal,
                        'aktifitas' => $row->aktifitas,
                        'customer' => $row->customer,
                        'nomor' => $row->user->phone
                    ]);
                })
                ->make(true);
         }
    }
}
