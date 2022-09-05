<?php

namespace App\Http\Controllers\Master;

use Carbon\Carbon;
use App\Models\Merk;
use App\Models\Satuan;
use App\Models\Product;
use App\Traits\CodeTrait;
use App\Models\Productgroup;
use Illuminate\Http\Request;
use App\Models\Productcategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\City;
use App\Http\Controllers\Controller;
use App\Models\Productsubcategory;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use CodeTrait;

    function __construct()
    {
        $this->middleware('permission:product-list');
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index()
    {

        $title = "PRODUCT";
        $products = Product::with(['categories', 'subcategories','podetails','penerimaanBarang'
                    ,'pengirimanBarang','pesananPenjualan']);    
        
                    // $data= $products->get();
                    // dd($data[0]);
        if (request()->ajax()) {
            return Datatables::of($products)
                ->addIndexColumn()

                ->editColumn('hargajual', function (Product $x) {
                    return "Rp. " . number_format($x->hargajual, 0, ',', '.');
                })

                ->addColumn('kategori', function (Product $p) {
                    return $p->categories->nama;
                })
                ->addColumn('subkategori', function (Product $z) {
                    return $z->subcategories->nama;
                })

                ->addColumn('action', function ($row) {
                    $editUrl = route('product.edit', ['product' => $row->id]);
                    $id = $row->id;
                    $podetail = count($row->podetails);
                    $penerimaanbarang = count($row->penerimaanBarang);
                    $pengirimanbarang = count($row->pengirimanBarang);
                    $pesananPenjualan = count($row->pesananPenjualan);

                    return view('master.product._formAction', compact('editUrl', 'id','penerimaanbarang','pengirimanbarang','pesananPenjualan','podetail'));

                })
                ->make(true);
        }


        return view('master.product.index', compact('title'));
    }

    public function create()
    {
        $title = "Produk";
        $product = new Product;
        $merks = Merk::get();
        $productgroups = Productgroup::get();
        $productcategories = Productcategory::get();
        $satuans = Satuan::get();
        $productsubcategories = [];
        return view('master.product.create', compact('title', 'product', 'merks', 'satuans', 'productgroups', 'productcategories', 'productsubcategories'));
    }

    public function getproductsubcategory(Request $request)
    {
        $productsubcategories = Productsubcategory::where('productcategory_id', $request->get('id'))
            ->pluck('nama', 'id');

        return response()->json($productsubcategories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'productgroup_id' => ['required'],
            'nama' => ['required', 'max:255'],
            'productcategory_id' => ['required'],
            'productsubcategory_id' => ['required'],
            'merk_id' => ['required'],
            'satuan' => ['required'],
            'hargajual' => ['required', 'numeric'],
            'hargabeli' => ['required', ' numeric'],
            'diskon_persen' => ['numeric', 'between:0,99.99'],
            'diskon_rp' => ['numeric'],
            'status' => ['required'],
            'status_exp' => ['required'],
        ]);

        $tglIjinEdar = $request->exp_ijinedar;
        if ($tglIjinEdar <> null) {
            $tglIjinEdar = Carbon::createFromFormat('d-m-Y', $tglIjinEdar)->format('Y-m-d');
        }

        $datas = $request->all();
        $datas['kode'] = $this->getKodeData("products", "P");
        $datas['exp_ijinedar'] = $tglIjinEdar;
        $datas['stok'] = '0';
        $datas['hpp'] = $request->hargabeli;

        //dd($datas);

        Product::create($datas);
        return redirect()->route('product.index')->with('status', 'Product baru berhasil ditambahkan !');
    }


    public function edit(Product $product)
    {
        $title = "PRODUCT";
        $merks = Merk::get();
        $productgroups = Productgroup::get();
        $productcategories = Productcategory::get();
        $satuans = Satuan::get();

        $id_kategori = $product->productcategory_id;
        $productsubcategories = Productsubcategory::where('productcategory_id', $id_kategori)->get();

        return view('master.product.edit', compact('title', 'product', 'merks', 'satuans', 'productgroups', 'productcategories', 'productsubcategories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'productgroup_id' => ['required'],
            'nama' => ['required', 'max:255'],
            'productcategory_id' => ['required'],
            'productsubcategory_id' => ['required'],
            'merk_id' => ['required'],
            'satuan' => ['required'],
            'hargajual' => ['required', 'numeric'],
            'hargabeli' => ['required', ' numeric'],
            'diskon_persen' => ['numeric', 'between:0,99.99'],
            'diskon_rp' => ['numeric'],
            'status' => ['required'],
            'status_exp' => ['required'],
        ]);

        $tglIjinEdar = $request->exp_ijinedar;
        if ($tglIjinEdar <> null) {
            $tglIjinEdar = Carbon::createFromFormat('d-m-Y', $tglIjinEdar)->format('Y-m-d');
        }

        $datas = $request->all();
        $datas['exp_ijinedar'] = $tglIjinEdar;

        $product->update($datas);
        return redirect()->route('product.index')->with('status', 'Data Produk berhasil diubah !');
    }

    public function delete(Request $request)
    {
        $data = Product::where('id', '=', $request->id)->get(['nama'])->first();
        $id = $request->id;
        $name = $data->nama;

        return view('master.product._confirmDelete', compact('name', 'id'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);
        $product->deleted_by = Auth::user()->id;
        $product->save();

        product::destroy($request->id);

        return redirect()->route('product.index')->with('status', 'Data product Berhasil Dihapus !');
    }

    public function show(Request $request)
    {
        $product = Product::where('id', '=', $request->id)->get()->first();

        return view('master.product._showDetail', compact('product'));
    }
}
