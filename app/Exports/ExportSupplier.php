<?php

namespace App\Exports;

use App\Models\Supplier;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportSupplier implements FromView
{
    
    public function view(): View
    {
        $supplier = Supplier::with('kategori','kelurahans','kecamatans','namakota','prov')->get();
        
        return view('laporan.master.supplier',compact('supplier'));
    }
}
