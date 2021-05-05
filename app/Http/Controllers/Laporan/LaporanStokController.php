<?php

namespace App\Http\Controllers\Laporan;

use App\Models\Product;
use App\Models\StokExp;
use App\Traits\CodeTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class LaporanStokController extends Controller
{
    use CodeTrait;

    function __construct()
    {
        $this->middleware('permission:laporanstok-list');
        $this->middleware('permission:laporanstokproduk-list', ['only' => ['stokproduk', 'stokprodukresult', 'expstokproduk']]);
        $this->middleware('permission:laporanstokkartu-list', ['only' => ['edit', 'update']]);
        $this->middleware('permission:laporanstokexp-list', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "Laporan Stok";
        return view('laporan.stok.index', compact('title'));
    }

    public function stokproduk()
    {
        $title = "Laporan Stok Produk";
        $products = Product::with(['categories', 'subcategories']);

        if (request()->ajax()) {
            return Datatables::of($products)
                ->addIndexColumn()

                ->addColumn('kategori', function (Product $p) {
                    return $p->categories->nama;
                })
                ->addColumn('subkategori', function (Product $z) {
                    return $z->subcategories->nama;
                })

                ->addColumn('action', function ($row) {
                    $selectUrl = route('laporanstok.detailstok', ['product' => $row->id]);
                    $id = $row->id;
                    return view('laporan.stok._actionStokProduk', compact('selectUrl', 'id'));
                })
                ->make(true);
        }


        return view('laporan.stok.stokproduk', compact('title'));
    }

    public function detailstok(Product $product)
    {
        $title = "Laporan Stok";
        $stokExp = StokExp::where('product_id', '=', $product->id)
            ->where('qty', '<>', '0')->get();
        return view('laporan.stok.detailstok', compact('title', 'stokExp'));
    }
}
