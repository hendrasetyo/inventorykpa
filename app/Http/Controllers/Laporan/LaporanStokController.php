<?php

namespace App\Http\Controllers\Laporan;

use App\Models\Product;
use App\Models\StokExp;
use App\Traits\CodeTrait;
use Illuminate\Http\Request;
use App\Models\StokExpDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
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
        return view('laporan.stok.detailstok', compact('title', 'product', 'stokExp'));
    }

    public function detailexp(StokExp $stokexp, Product $product)
    {
        $title = "Laporan Stok";
        //$stokExpDetail = StokExpDetail::with('pengiriman')->where('stok_exp_id', '=', $stokexp->id)->get();

        $stokExpDetail = DB::table('stok_exp_details')
            ->select(DB::raw('id, tanggal, stok_exp_id, product_id, qty, id_pb,(select kode from penerimaan_barangs where id = id_pb) as kode_pb, id_pb_detail, id_sj,(select kode from pengiriman_barangs where id = id_sj) as kode_sj, id_sj_detail'))
            ->where('stok_exp_id', '=', $stokexp->id)
            ->whereNull('deleted_at')
            ->get();
        //dd($stokExpDetail);

        return view('laporan.stok.detailexp', compact('title',  'product', 'stokExpDetail'));
    }
}
