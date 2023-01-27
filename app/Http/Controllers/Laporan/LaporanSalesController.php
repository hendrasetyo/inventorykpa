<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\KunjunganSales;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanSalesController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $title = "Laporan Kunjungan Sales";
        $user = User::with(['roles' => function ($query){
                $query->where('name','Sales')->select('name','id');
        }])->select('id','name')->whereHas('roles')->get();

        foreach ($user as $key => $value) {
            if (count($value->roles) > 0) {
                $sales = array([
                    'id' => $value->id,
                    'name' => $value->name
                ]);
            }
        }

        // dd($sales);
       
        return view('laporan.sales.index',compact('title','sales'));
    }


    public function datatable(Request $request)
    {
        $sales = KunjunganSales::with('user')->select('id','customer','user_id','aktifitas','tanggal')->orderByDesc('id');

        if ($request->tanggalMulai) {
           $sales->where('tanggal','>',$request->tanggalMulai);
        }

        if ($request->tanggalSelesai) {
            $sales->where('tanggal','<',$request->tanggalSelesai);
        }

        if ($request->sales !== 'all') {
            $sales->where('user_id',$request->sales);
        }

        $datasales = $sales->get();

        if (request()->ajax()) {
            return DataTables::of($datasales)
                ->addIndexColumn()
                ->editColumn('tanggal', function (KunjunganSales $sj) {
                    return $sj->tanggal ? with(new Carbon($sj->tanggal))->format('d-m-Y') : '';
                })
                ->editColumn('user', function (KunjunganSales $sj) {
                    return $sj->user->name;
                })
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('laporan.sales.partial._form-action', compact('id'));
                })
                ->make(true);
         }
    }
}
