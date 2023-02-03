<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:teknisi-list',['only' => ['index','datatable'] ]);
        $this->middleware('permission:teknisi-create', ['only' => ['create','store']]);
        $this->middleware('permission:teknisi-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:teknisi-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = 'Maintenance Produk';
        return view('maintenanceproduk.index',compact('title'));
    }

    public function datatable(Request $request)
    {
        
    }


    public function create()
    {
       $title = 'Perawatan Produk';
       return view('maintenanceproduk.create',compact('title'));
    }


}
