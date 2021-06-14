<?php

namespace App\Http\Controllers\Penjualan;

use Carbon\Carbon;
use App\Models\TempSo;
use App\Models\Product;
use App\Models\TempPpn;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Komoditas;
use App\Traits\CodeTrait;
use App\Models\TempDiskon;
use Illuminate\Http\Request;
use App\Models\Kategoripesanan;
use App\Models\PesananPenjualan;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PesananPenjualanDetail;
use App\Models\Sales;

class PesananPenjualanController extends Controller
{
    use CodeTrait;
    function __construct()
    {
        $this->middleware('permission:pesananpenjualan-list');
        $this->middleware('permission:pesananpenjualan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pesananpenjualan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pesananpenjualan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "Pesanan Penjualan";
        $pesananpenjualan = PesananPenjualan::with(['customers', 'kategoripesanan', 'komoditas', 'statusSO']);

        if (request()->ajax()) {
            return Datatables::of($pesananpenjualan)
                ->addIndexColumn()
                ->addColumn('customer', function (PesananPenjualan $so) {
                    return $so->customers->nama;
                })
                ->addColumn('status', function (PesananPenjualan $so) {
                    return $so->statusSO->nama;
                })
                ->editColumn('tanggal', function (PesananPenjualan $so) {
                    return $so->tanggal ? with(new Carbon($so->tanggal))->format('d-m-Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('pesananpenjualan.edit', ['pesananpenjualan' => $row->id]);
                    $showUrl = route('pesananpenjualan.show', ['pesananpenjualan' => $row->id]);
                    $id = $row->id;
                    $status = $row->status_so_id;
                    return view('penjualan.pesananpenjualan._formAction', compact('editUrl', 'showUrl', 'id', 'status'));
                })
                ->make(true);
        }
        return view('penjualan.pesananpenjualan.index', compact('title'));
    }

    public function create()
    {
        $title = "Pesanan Penjualan";
        $pesananpenjualan = new PesananPenjualan;
        $customers = Customer::get();
        $komoditass = Komoditas::get();
        $kategoris = Kategoripesanan::get();
        $saless = Sales::get();
        $tglNow = Carbon::now()->format('d-m-Y');

        //delete temp
        $deletedTempDetil = TempSo::where('created_at', '<', Carbon::today())->delete();
        $deletedTempDetil = TempSo::where('user_id', '=', Auth::user()->id)->delete();
        $deletedTempDiskon = TempDiskon::where('jenis', '=', "SO")
            ->where('user_id', '=', Auth::user()->id)
            ->delete();
        $deletedTempPPN = TempPpn::where('jenis', '=', "SO")
            ->where('user_id', '=', Auth::user()->id)
            ->delete();
        //insertt temp
        $tempDiskon = TempDiskon::create(['jenis' => 'SO', 'persen' => '0', 'rupiah' => '0', 'user_id' => Auth::user()->id]);
        $tempPPN    = TempPpn::create(['jenis' => 'SO', 'persen' => '10', 'user_id' => Auth::user()->id]);


        return view('penjualan.pesananpenjualan.create', compact('title', 'saless', 'tglNow', 'customers', 'pesananpenjualan', 'komoditass', 'kategoris'));
    }

    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'customer_id' => ['required'],
            'tanggal' => ['required'],
            'komoditas_id' => ['required'],
            'kategoripesanan_id' => ['required'],
            'sales_id' => ['required'],
        ]);

        $datas = $request->all();

        $subtotal = TempSo::where('user_id', '=', Auth::user()->id)->sum('total');
        $diskon = TempDiskon::where('jenis', '=', "SO")
            ->where('user_id', '=', Auth::user()->id)
            ->get()->first();
        $diskon_persen = $diskon->persen;
        $diskon_rupiah = $diskon->rupiah;

        $total_diskon = ($subtotal * ($diskon_persen / 100)) + $diskon_rupiah;
        $total_diskon_header = $total_diskon;
        $total_diskon_detail = TempSo::where('user_id', '=', Auth::user()->id)->sum('total_diskon');

        $total = $subtotal - $total_diskon;
        $ppnData = TempPpn::where('jenis', '=', "SO")
            ->where('user_id', '=', Auth::user()->id)
            ->get()->first();
        $ppn_persen = $ppnData->persen;
        $ppn = $total * ($ppn_persen / 100);
        $ongkir = TempSo::where('user_id', '=', Auth::user()->id)->sum('ongkir');
        $grandtotal = $total + $ppn + $ongkir;

        $tanggal = $request->tanggal;
        if ($tanggal <> null) {
            $tanggal = Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');
        }

        $dataTemp = TempSo::where('user_id', '=', Auth::user()->id)->get();
        $jmlTemp = $dataTemp->count();
        if ($jmlTemp < 1) {
            return redirect()->route('pesananpenjualan.index')->with('gagal', 'Tidak ada barang yang diinputkan, Pesanan Penjualan Gagal Disimpan!');
        }

        $datas['kode'] = $this->getKodeTransaksi("pesanan_penjualans", "SO");
        $datas['tanggal'] = $tanggal;
        $datas['status_so_id'] = "1";
        $datas['diskon_persen'] = $diskon_persen;
        $datas['diskon_rupiah'] = $diskon_rupiah;
        $datas['subtotal'] = $subtotal;
        $datas['total_diskon_header'] = $total_diskon_header;
        $datas['total_diskon_detail'] = $total_diskon_detail;
        $datas['total'] =  $total;
        $datas['ppn'] = $ppn_persen;
        $datas['ongkir'] = $ongkir;
        $datas['grandtotal'] = $grandtotal;

        $id_so = PesananPenjualan::create($datas)->id;

        //insert detail

        foreach ($dataTemp as $a) {

            $detail = new PesananPenjualanDetail;
            $detail->pesanan_penjualan_id = $id_so;
            $detail->tanggal = $tanggal;
            $detail->product_id = $a->product_id;
            $detail->qty = $a->qty;
            $detail->qty_sisa = $a->qty;
            $detail->satuan = $a->satuan;
            $detail->hargajual = $a->hargajual;
            $detail->diskon_persen = $a->diskon_persen;
            $detail->diskon_rp = $a->diskon_rp;
            $detail->subtotal = $a->subtotal;
            $detail->total_diskon = $a->total_diskon;
            $detail->total = $a->total;
            $detail->ongkir = $a->ongkir;
            $detail->keterangan = $a->keterangan;

            $detail->save();
        }

        return redirect()->route('pesananpenjualan.index')->with('status', 'Pesanan Penjualan (Sales Order) berhasil dibuat !');
    }

    public function caribarang()
    {
        $products = Product::with(['categories', 'subcategories']);
        $produk = "";
        if (request()->ajax()) {
            return Datatables::of($products)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('penjualan.pesananpenjualan._pilihBarang', compact('id'));
                })
                ->make(true);
        }
        return view('penjualan.pesananpenjualan._caribarang', compact('produk'));
    }

    public function setbarang(Request $request)
    {
        $product = Product::where('id', '=', $request->id)->get()->first();
        $mode = "new";
        return view('penjualan.pesananpenjualan._setbarang', compact('product', 'mode'));
    }
    public function inputtempso(Request $request)
    {
        $datas = $request->all();
        $harga = $request->hargajual;

        $harga = str_replace('.', '', $harga) * 1;
        $ongkir = $request->ongkir;
        $ongkir = str_replace('.', '', $ongkir) * 1;

        $subtotal = $request->qty * $harga;
        $total_diskon = (($subtotal * ($request->diskon_persen / 100)) + $request->diskon_rp);
        $total = $subtotal - $total_diskon;

        $datas['hargajual'] = $harga;
        $datas['subtotal'] = $subtotal;
        $datas['total_diskon'] = $total_diskon;
        $datas['total'] = $total;
        $datas['user_id'] = Auth::user()->id;
        $datas['ongkir'] = $ongkir;

        TempSo::create($datas);
    }

    public function loadtempso(Request $request)
    {
        $tempso = TempSo::with(['products'])
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        return view('penjualan.pesananpenjualan._temptabelso', compact('tempso'));
    }

    public function destroy_detail(Request $request)
    {
        $id = $request->id;
        TempSo::destroy($id);
    }

    public function editbarang(Request $request)
    {
        $item = TempSo::where('id', '=', $request->id)->get()->first();
        $id_product = $item->product_id;
        $product = new Product;
        $productx = Product::where('id', '=', $id_product)->get()->first();
        $product_name = $productx->nama;
        $mode = "edit";
        return view('penjualan.pesananpenjualan._setbarang', compact('product_name', 'mode', 'item', 'product'));
    }

    public function updatebarang(Request $request)
    {
        //dd($request->hargajual);
        $harga = $request->hargajual;
        $harga = str_replace('.', '', $harga) * 1;
        $subtotal = $request->qty * $harga;
        $total_diskon = (($subtotal * ($request->diskon_persen / 100)) + $request->diskon_rp);
        $total = $subtotal - $total_diskon;
        $ongkir = $request->ongkir;
        $ongkir = str_replace('.', '', $ongkir) * 1;

        $temp = TempSo::find($request->id);
        $temp->hargajual = $harga;
        $temp->qty = $request->qty;
        $temp->diskon_persen = $request->diskon_persen;
        $temp->diskon_rp = $request->diskon_rp;
        $temp->ongkir = $ongkir;
        $temp->keterangan = $request->keterangan;
        $temp->subtotal = $subtotal;
        $temp->total_diskon = $total_diskon;
        $temp->total = $total;

        $temp->save();
    }

    public function editdiskon(Request $request)
    {
        $item = TempDiskon::where('jenis', '=', "SO")
            ->where('user_id', '=', Auth::user()->id)
            ->get()->first();
        $id_diskon = $item->id;
        $diskon_persen = $item->persen;
        $diskon_rupiah = $item->rupiah;

        return view('penjualan.pesananpenjualan._setdiskon', compact('id_diskon', 'diskon_persen', 'diskon_rupiah'));
    }

    public function updatediskon(Request $request)
    {
        $id_diskon = $request->id_diskon;
        $diskon = TempDiskon::find($id_diskon);
        $diskon->persen = $request->diskon_persen;
        $diskon->rupiah = $request->diskon_rupiah;
        $diskon->save();
    }

    public function editppn(Request $request)
    {
        $item = TempPpn::where('jenis', '=', "SO")
            ->where('user_id', '=', Auth::user()->id)
            ->get()->first();
        $id_ppn = $item->id;
        $persen = $item->persen;

        return view('penjualan.pesananpenjualan._setppn', compact('id_ppn', 'persen'));
    }

    public function updateppn(Request $request)
    {
        $id_ppn = $request->id_ppn;
        $ppn = TempPpn::find($id_ppn);
        $ppn->persen = $request->persen;
        $ppn->save();
    }

    public function hitungsubtotal(Request $request)
    {
        $subtotal = TempSo::where('user_id', '=', Auth::user()->id)->sum('total');

        return number_format($subtotal, 0, ',', '.');
    }

    public function hitungdiskon(Request $request)
    {
        $subtotal = TempSo::where('user_id', '=', Auth::user()->id)->sum('total');
        $diskon = TempDiskon::where('jenis', '=', "SO")
            ->where('user_id', '=', Auth::user()->id)
            ->get()->first();
        $diskon_persen = $diskon->persen;
        $diskon_rupiah = $diskon->rupiah;

        $total_diskon = ($subtotal * ($diskon_persen / 100)) + $diskon_rupiah;
        if ($total_diskon == 0) {
            return $total_diskon;
        } else {
            return number_format($total_diskon, 0, ',', '.');
        }
    }

    public function hitungtotal(Request $request)
    {
        $subtotal = TempSo::where('user_id', '=', Auth::user()->id)->sum('total');
        $diskon = TempDiskon::where('jenis', '=', "SO")
            ->where('user_id', '=', Auth::user()->id)
            ->get()->first();
        $diskon_persen = $diskon->persen;
        $diskon_rupiah = $diskon->rupiah;

        $total_diskon = ($subtotal * ($diskon_persen / 100)) + $diskon_rupiah;
        $total = $subtotal - $total_diskon;
        if ($total == 0) {
            return $total;
        } else {
            return number_format($total, 0, ',', '.');
        }
    }

    public function hitungppn(Request $request)
    {
        $subtotal = TempSo::where('user_id', '=', Auth::user()->id)->sum('total');
        $diskon = TempDiskon::where('jenis', '=', "SO")
            ->where('user_id', '=', Auth::user()->id)
            ->get()->first();
        $diskon_persen = $diskon->persen;
        $diskon_rupiah = $diskon->rupiah;

        $total_diskon = ($subtotal * ($diskon_persen / 100)) + $diskon_rupiah;
        $total = $subtotal - $total_diskon;

        $item = TempPpn::where('jenis', '=', "SO")
            ->where('user_id', '=', Auth::user()->id)
            ->get()->first();
        $persen = $item->persen;
        $ppn = $total * ($persen / 100);

        if ($ppn == 0) {
            return $ppn;
        } else {
            return number_format($ppn, 0, ',', '.');
        }
    }

    public function hitungongkir(Request $request)
    {
        $ongkir = TempSo::where('user_id', '=', Auth::user()->id)->sum('ongkir');

        if ($ongkir == 0) {
            return $ongkir;
        } else {
            return number_format($ongkir, 0, ',', '.');
        }
    }

    public function hitunggrandtotal(Request $request)
    {
        $subtotal = TempSo::where('user_id', '=', Auth::user()->id)->sum('total');
        $diskon = TempDiskon::where('jenis', '=', "SO")
            ->where('user_id', '=', Auth::user()->id)
            ->get()->first();
        $diskon_persen = $diskon->persen;
        $diskon_rupiah = $diskon->rupiah;

        $total_diskon = ($subtotal * ($diskon_persen / 100)) + $diskon_rupiah;
        $total = $subtotal - $total_diskon;

        $item = TempPpn::where('jenis', '=', "SO")
            ->where('user_id', '=', Auth::user()->id)
            ->get()->first();
        $persen = $item->persen;
        $ppn = $total * ($persen / 100);

        $ongkir = TempSo::where('user_id', '=', Auth::user()->id)->sum('ongkir');
        $grandtotal = $total + $ppn + $ongkir;

        if ($grandtotal == 0) {
            return $grandtotal;
        } else {
            return number_format($grandtotal, 0, ',', '.');
        }
    }

    public function delete(Request $request)
    {
        $data = PesananPenjualan::where('id', '=', $request->id)->get()->first();
        $id = $request->id;
        $status_so_id = $data->status_so_id;
        if ($status_so_id >= 3) {
            $can_delete = "NO";
        } else {
            $can_delete = "YES";
        }

        return view('penjualan.pesananpenjualan._confirmDelete', compact('id', 'can_delete'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $pesananpenjualan = PesananPenjualan::find($id);
        $pesananpenjualan->deleted_by = Auth::user()->id;
        $pesananpenjualan->save();

        PesananPenjualan::destroy($request->id);

        $detail = PesananPenjualanDetail::where('pesanan_penjualan_id', '=', $id)->get();
        foreach ($detail as $d) {
            PesananPenjualanDetail::destroy($d->id);
        }

        return redirect()->route('pesananpenjualan.index')->with('status', 'Data Pesanan Penjualan Berhasil Dihapus !');
    }

    public function posting(Request $request)
    {
        $data = PesananPenjualan::where('id', '=', $request->id)->get()->first();
        $id = $request->id;
        $status_so_id = $data->status_so_id;
        if ($status_so_id == 1) {
            $can_posting = "YES";
        } else {
            $can_posting = "NO";
        }

        return view('penjualan.pesananpenjualan._confirmPosting', compact('id', 'can_posting'));
    }

    public function posted(Request $request)
    {
        $id = $request->id;
        $pesananpenjualan = PesananPenjualan::find($id);
        $pesananpenjualan->status_so_id = "2";
        $pesananpenjualan->save();

        return redirect()->route('pesananpenjualan.index')->with('status', 'Pesanan Penjualan (SO) berhasil di posting !');
    }

    public function show(PesananPenjualan $pesananpenjualan)
    {
        $title = "Pesanan Pembelian Detail";
        $pesananpenjualandetails = PesananPenjualanDetail::with('products')
            ->where('pesanan_penjualan_id', '=', $pesananpenjualan->id)->get();

        return view('penjualan.pesananpenjualan.show', compact('title', 'pesananpenjualan', 'pesananpenjualandetails'));
    }
}
