<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportCustomer implements FromView
{
    public function view(): View
    {
        $customer = Customer::with('kategori','kelurahans','kecamatans','namakota','prov')->get();
        
        return view('laporan.master.customer',compact('customer'));
    }
}
