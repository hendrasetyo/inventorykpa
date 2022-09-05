<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanStockExport implements FromView
{

    public function view(): View
    {   

        $product = Product::with('categories')
                    ->with('merks')
                    ->with('categories')
                    ->with('subcategories')
                    ->get();

        return view('laporan.stok.export.exportProduct',[
            'product' => $product
        ]);
    }
}
