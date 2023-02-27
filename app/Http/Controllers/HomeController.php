<?php

namespace App\Http\Controllers;

use App\Models\FakturPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {        
        
       
        
        return view('home');
    }


    public function chartyear(Request $request)
    {
        $results = FakturPenjualan::orderBy('tanggal');
        if ($request->year) {
            $res=$results->whereYear('tanggal',$request->year);       
        }else{
            $res=$results;
        }
        
       $hasil= $res->groupBy(DB::raw("DATE_FORMAT(tanggal, '%m-%Y')"))
             ->select(
                    DB::raw("DATE_FORMAT(tanggal, '%m') as tanggal_penjualan"),
                    DB::raw("sum(grandtotal) as grandtotal_penjualan")
                )        
                ->get();
    
        $laba = array();  
        $data=[]; 
        $j=0;

        
        
        foreach ($hasil as $key => $value) {
            $data[(int)$value->tanggal_penjualan] = [
                'grandtotal' => (int)$value->grandtotal_penjualan
            ];
        }
        
        
        for ($i=1; $i <= 12; $i++) { 
            if (!empty($data[$i])) {
                $laba[] = $data[$i]['grandtotal'];
            }else{
                $laba[] = 0;
            }
        }

        return response()->json(
            $laba
        );
    }
}
