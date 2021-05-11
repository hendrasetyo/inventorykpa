<?php

namespace App\Http\Controllers\Pembelian;

use Carbon\Carbon;
use App\Models\TempPb;
use App\Models\Product;
use App\Models\StokExp;
use App\Traits\CodeTrait;
use Illuminate\Http\Request;
use App\Models\StokExpDetail;
use App\Models\PenerimaanBarang;
use App\Models\PesananPembelian;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\PenerimaanBarangDetail;
use App\Models\PesananPembelianDetail;

class PenerimaanBarangController extends Controller
{
    use CodeTrait;

    function __construct()
    {
        $this->middleware('permission:penerimaanbarang-list');
        $this->middleware('permission:penerimaanbarang-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:penerimaanbarang-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:penerimaanbarang-delete', ['only' => ['destroy']]);
    }

    public function index()
    {


        $title = "Penerimaan Barang";
        $penerimaanbarang = PenerimaanBarang::with(['suppliers',  'statusPB', 'po']);

        if (request()->ajax()) {
            return Datatables::of($penerimaanbarang)
                ->addIndexColumn()
                ->addColumn('supplier', function (PenerimaanBarang $pb) {
                    return $pb->suppliers->nama;
                })
                ->addColumn('kode_po', function (PenerimaanBarang $pb) {
                    return $pb->po->kode;
                })
                ->addColumn('status', function (PenerimaanBarang $pb) {
                    return $pb->statusPB->nama;
                })
                ->editColumn('tanggal', function (PenerimaanBarang $pb) {
                    return $pb->tanggal ? with(new Carbon($pb->tanggal))->format('d-m-Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('penerimaanbarang.edit', ['penerimaanbarang' => $row->id]);
                    $expUrl = route('penerimaanbarang.inputexp', ['penerimaanbarang' => $row->id]);
                    $showUrl = route('penerimaanbarang.show', ['penerimaanbarang' => $row->id]);
                    $id = $row->id;
                    $status = $row->status_pb_id;
                    return view('pembelian.penerimaanbarang._formAction', compact('editUrl', 'showUrl', 'id', 'status', 'expUrl'));
                })
                ->make(true);
        }


        return view('pembelian.penerimaanbarang.index', compact('title'));
    }

    public function listpo()
    {
        $title = "Daftar Pesanan Pembelian";
        $pesananpembelians = PesananPembelian::with('suppliers', 'statusPO')
            ->where('status_po_id', '<=', '3')
            ->where('status_po_id', '<>', '1')
            ->get();
        if (request()->ajax()) {
            return Datatables::of($pesananpembelians)
                ->addIndexColumn()
                ->addColumn('supplier', function (PesananPembelian $po) {
                    return $po->suppliers->nama;
                })
                ->addColumn('status', function (PesananPembelian $po) {
                    return $po->statusPO->nama;
                })
                ->editColumn('tanggal', function (PesananPembelian $po) {
                    return $po->tanggal ? with(new Carbon($po->tanggal))->format('d-m-Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $pilihUrl = route('penerimaanbarang.create', ['pesananpembelian' => $row->id]);
                    $id = $row->id;
                    return view('pembelian.penerimaanbarang._pilihAction', compact('pilihUrl', 'id'));
                })
                ->make(true);
        }

        //dd($pesananpembelian);
        return view('pembelian.penerimaanbarang.listpo', compact('title', 'pesananpembelians'));
    }

    public function create(PesananPembelian $pesananpembelian)
    {
        $title = "Penerimaan Barang";
        //delete temp
        $deletedTempDetil = TempPb::where('created_at', '<', Carbon::today())->delete();
        $deletedTempDetil = TempPb::where('user_id', '=', Auth::user()->id)->delete();

        //ambil list item PO untuk dimasukkan ke penerimaan
        $id_po = $pesananpembelian->id;
        $POdetails = PesananPembelianDetail::with('products')
            ->where('pesanan_pembelian_id', '=', $id_po)->get();

        return view('pembelian.penerimaanbarang.create', compact('title', 'pesananpembelian', 'POdetails'));
    }

    public function setbarang(Request $request)
    {

        $product = PesananPembelianDetail::with('products')->where('id', '=', $request->id)->get()->first();
        $mode = "new";
        return view('pembelian.penerimaanbarang._setbarang', compact('product', 'mode'));
    }

    public function loadtemppb(Request $request)
    {
        $temppb = TempPb::with(['products'])
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        return view('pembelian.penerimaanbarang._temptabelpb', compact('temppb'));
    }

    public function inputtemppb(Request $request)
    {
        $id_detail = $request->detail_id;
        $qty_terima = $request->qty;
        $keterangan = $request->keterangan;

        $detailPO = PesananPembelianDetail::with('products')->where('id', '=', $id_detail)->get()->first();
        $product_id = $detailPO->product_id;
        $qty_pesanan = $detailPO->qty;
        $satuan = $detailPO->satuan;
        $qty_sisa = $detailPO->qty_sisa;
        $qty_sisa_terima = $qty_sisa - $qty_terima;
        //validasi
        //1. cek item sudah dimasukkan apa belum
        $jmlItem = TempPb::where('product_id', '=', $product_id)->count();
        if ($qty_terima > 0) {
            if ($jmlItem == 0) {
                //2. cek qty yg diinput berlebihan/tidak
                if ($qty_terima <= $qty_sisa) {
                    $datas['pesanan_pembelian_detail_id'] = $id_detail;
                    $datas['product_id'] = $product_id;
                    $datas['qty'] = $qty_terima;
                    $datas['qty_sisa'] = $qty_sisa;
                    $datas['qty_pesanan'] = $qty_pesanan;
                    $datas['satuan'] = $satuan;
                    $datas['keterangan'] = $keterangan;
                    $datas['user_id'] = Auth::user()->id;
                    TempPb::create($datas);
                } else {
                    $request->session()->flash('status', 'Qty melebihi pesanan, periksa kembali inputan anda!');
                }
            } else {
                $request->session()->flash('status', 'Produk sudah diinputkan, silahkan periksa kembali inputan anda!');
            }
        } else {
            $request->session()->flash('status', 'Qty tidak boleh nol!');
        }
    }

    public function destroy_detail(Request $request)
    {
        $id = $request->id;
        TempPb::destroy($id);
    }

    public function editbarang(Request $request)
    {
        $item = TempPb::where('id', '=', $request->id)->get()->first();
        $id_product = $item->product_id;
        $pesanan_pembelian_detail_id = $item->pesanan_pembelian_detail_id;
        $product = new PesananPembelianDetail;
        $product = PesananPembelianDetail::with('products')->where('id', '=', $pesanan_pembelian_detail_id)->get()->first();
        $mode = "edit";
        return view('pembelian.penerimaanbarang._setbarang', compact('mode', 'item', 'product'));
    }

    public function updatebarang(Request $request)
    {
        $id = $request->id;
        $po_detail_id = $request->po_detail_id;
        $qty_terima = $request->qty;
        $keterangan = $request->keterangan;

        $temp = TempPb::find($id);
        $qty_pesanan = $temp->qty_pesanan;
        $qty_sisa = $temp->qty_sisa;

        if ($qty_terima <= $qty_sisa) {
            if ($qty_terima > 0) {
                $temp->qty = $qty_terima;
                $temp->keterangan =  $keterangan;

                $temp->save();
            } else {
                $request->session()->flash('status', 'Qty tidak boleh nol!');
            }
        } else {
            $request->session()->flash('status', 'Qty melebihi pesanan, periksa kembali inputan anda!');
        }
    }
    public function store(Request $request, PesananPembelian $pesananpembelian)
    {

        $request->validate([
            'tanggal' => ['required'],
        ]);

        $datas = $request->all();
        $tanggal = $request->tanggal;
        if ($tanggal <> null) {
            $tanggal = Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');
        }
        $pesanan_pembelian_id = $pesananpembelian->id;
        $supplier_id = $pesananpembelian->supplier_id;

        $dataTemp = TempPb::where('user_id', '=', Auth::user()->id)->get();
        $jmlTemp = $dataTemp->count();
        if ($jmlTemp < 1) {
            return redirect()->route('penerimaanbarang.index')->with('gagal', 'Tidak ada barang yang diinputkan, Penerimaan Barang Gagal Disimpan!');
        }

        $kode = $this->getKodeTransaksi("penerimaan_barangs", "PB");
        $datas['kode'] = $kode;
        $datas['tanggal'] = $tanggal;
        $datas['pesanan_pembelian_id'] = $pesanan_pembelian_id;
        $datas['supplier_id'] = $supplier_id;
        $datas['status_pb_id'] = "1";

        $id_pb = PenerimaanBarang::create($datas)->id;

        //isi detail
        $test = "";
        foreach ($dataTemp as $a) {

            /////// calkulasi HPP  ///////
            $detailPesanan = PesananPembelianDetail::find($a->pesanan_pembelian_detail_id);
            $hargabeli = $detailPesanan->hargabeli;
            $diskon_persen = $detailPesanan->diskon_persen;
            $diskon_rp = $detailPesanan->diskon_rp;
            $totaldiskon = ($hargabeli * ($diskon_persen / 100)) + $diskon_rp;
            $hargabeli_fix = $hargabeli - $totaldiskon;

            $stok_lama = 0;
            $hpp_lama = 0;
            $stok_baru = 0;

            $product_id = $a->product_id;
            $product = new Product;
            $product = Product::find($a->product_id);
            $stok_lama = $product->stok;
            $hpp_lama = $product->hpp;
            $nilai_lama = $stok_lama * $hpp_lama;
            $status_exp = $product->status_exp;
            if ($status_exp == 1) {
                $status_exp_detil = 0;
            } else {
                $status_exp_detil = 1;
            }

            $nilai_terima = $a->qty * $hargabeli_fix;
            $stok_baru = $stok_lama + $a->qty;
            $nilai_baru = $nilai_lama + $nilai_terima;
            $hpp_baru = ROUND(($nilai_baru / $stok_baru), 2);
            $product->stok = $stok_baru;
            $product->hpp = $hpp_baru;
            $product->save();
            ////////// end hpp //////////

            // ########## start input detail ###########
            $detail = new PenerimaanBarangDetail;
            $detail->tanggal = $tanggal;
            $detail->penerimaan_barang_id = $id_pb;
            $detail->pesanan_pembelian_id = $pesanan_pembelian_id;
            $detail->pesanan_pembelian_detail_id = $a->pesanan_pembelian_detail_id;
            $detail->product_id = $product_id;
            $detail->qty = $a->qty;
            $detail->qty_sisa = $a->qty_sisa;
            $detail->qty_pesanan = $a->qty_pesanan;
            $detail->satuan = $a->satuan;
            $detail->keterangan = $a->keterangan;
            $detail->status_exp = $status_exp_detil;
            $detail->save();
            // ########## end input detail #############

            //######### start update stok ##############
            // $product2 = new Product;
            // $product2 = Product::find($a->product_id)->first();
            // $product2->stok = $stok_baru;
            // $product2->hpp = $hpp_baru;
            // $product2->save();

            // Product::where('id', $a->product_id)
            //     ->update(['stok' => $stok_baru, 'hpp' => $hpp_baru]);
            //######### end update stok ################

            //######### start add INV TRANS ############
            $inventoryTrans = new InventoryTransaction;
            $inventoryTrans->tanggal = $tanggal;
            $inventoryTrans->product_id = $product_id;
            $inventoryTrans->qty = $a->qty;
            $inventoryTrans->stok = $stok_baru;
            $inventoryTrans->hpp = $hpp_baru;
            $inventoryTrans->jenis = "PB";
            $inventoryTrans->jenis_id = $kode;

            $inventoryTrans->save();
            //######### end add INV TRANS ############
            $test = $test . $a->product_id . "(" . $stok_baru . ");";

            //############# start update Qty Sisa PO #############
            $detailPOupdate = new PesananPembelianDetail;
            $detailPOupdate = PesananPembelianDetail::find($a->pesanan_pembelian_detail_id);
            $detailPOupdate->qty_sisa = ($a->qty_sisa - $a->qty);
            $detailPOupdate->save();
            //############# end update Qty Sisa PO #############
        }
        //dd($index);
        //############# start update status PO #############
        $totalPesananPO = PesananPembelianDetail::where('pesanan_pembelian_id', '=', $pesanan_pembelian_id)->sum('qty');
        $totalSisaPO = PesananPembelianDetail::where('pesanan_pembelian_id', '=', $pesanan_pembelian_id)->sum('qty_sisa');
        $terkirim = $totalPesananPO - $totalSisaPO;

        if ($terkirim == $totalPesananPO) {
            $status = "4";
        } else {
            $status = "3";
        }
        $POmain = PesananPembelian::find($pesanan_pembelian_id);
        $POmain->status_po_id = $status;
        $POmain->save();
        //############# end update status PO #############

        return redirect()->route('penerimaanbarang.index')->with('status', 'Penerimaan barang berhasil dibuat !');
    }

    public function inputexp(PenerimaanBarang $penerimaanbarang)
    {
        $title = "Pengaturan Expired Date";
        $penerimaanbarang_id =  $penerimaanbarang->id;
        $detailItem = PenerimaanBarangDetail::where('penerimaan_barang_id', '=', $penerimaanbarang_id)->get();
        // dd($detailItem);
        return view('pembelian.penerimaanbarang.inputexp', compact('penerimaanbarang', 'title', 'detailItem'));
    }

    public function setexp(PenerimaanBarangDetail $penerimaanbarangdetail)
    {
        $title = "Pengaturan Expired Date";
        $penerimaanbarangdetail_id = $penerimaanbarangdetail->id;
        $penerimaanbarang_id = $penerimaanbarangdetail->penerimaan_barang_id;
        $penerimaanbarang = PenerimaanBarang::find($penerimaanbarang_id);
        $listExp = StokExpDetail::where('id_pb_detail', '=', $penerimaanbarangdetail_id)->get();
        return view('pembelian.penerimaanbarang.setexp', compact('penerimaanbarangdetail', 'title', 'listExp', 'penerimaanbarang'));
    }

    public function formsetexp(PenerimaanBarangDetail $penerimaanbarangdetail)
    {
        $title = "Form Pengaturan Expired Date";
        return view('pembelian.penerimaanbarang.formexp', compact('penerimaanbarangdetail', 'title'));
    }

    public function saveexp(Request $request, PenerimaanBarangDetail $penerimaanbarangdetail)
    {
        $request->validate([
            'qty' => ['required'],
            'tanggal' => ['required'],
        ]);

        $datas = $request->all();

        $tanggal = $request->tanggal;
        if ($tanggal <> null) {
            $tanggal = Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');
        }

        $qty = $request->qty;
        if ($qty < 1) {
            return redirect()->route('penerimaanbarang.setexp', $penerimaanbarangdetail)->with('status', 'Qty harus lebih dari nol');
        }

        $penerimaanbarangdetail_id = $penerimaanbarangdetail->id;
        $product_id =  $penerimaanbarangdetail->product_id;
        $penerimaanbarang_id = $penerimaanbarangdetail->penerimaan_barang_id;
        $qty_diterima = $penerimaanbarangdetail->qty;


        //get jumlah qty di exp data
        $totalQtyExp = StokExpDetail::where('id_pb_detail', '=', $penerimaanbarangdetail_id)->sum('qty');
        $qtyExpNow = $totalQtyExp + $qty;

        if ($qtyExpNow <= $qty_diterima) {
            $mainStokExp = StokExp::where('tanggal', '=', $tanggal)
                ->where('product_id', '=', $product_id)
                ->count();
            if ($mainStokExp > 0) {
                //ada data, tinggal update stok
                $stokExp =  StokExp::where('tanggal', '=', $tanggal)
                    ->where('product_id', '=', $product_id)->first();
                $id_stokExp = $stokExp->id;
                $stokExp->qty += $qty;
                $stokExp->save();

                //insert detail
                $stokExpDetail = new StokExpDetail;
                $stokExpDetail->tanggal = $tanggal;
                $stokExpDetail->stok_exp_id = $id_stokExp;
                $stokExpDetail->product_id = $product_id;
                $stokExpDetail->qty = $qty;
                $stokExpDetail->id_pb = $penerimaanbarang_id;
                $stokExpDetail->id_pb_detail = $penerimaanbarangdetail_id;
                $stokExpDetail->save();
            } else {
                //tidak ada data, harus insert stok
                $datas['tanggal'] = $tanggal;
                $datas['product_id'] = $product_id;
                $datas['qty'] = $qty;
                $id_stokExp = StokExp::create($datas)->id;

                //insert detail;
                $stokExpDetail = new StokExpDetail;
                $stokExpDetail->tanggal = $tanggal;
                $stokExpDetail->stok_exp_id = $id_stokExp;
                $stokExpDetail->product_id = $product_id;
                $stokExpDetail->qty = $qty;
                $stokExpDetail->id_pb = $penerimaanbarang_id;
                $stokExpDetail->id_pb_detail = $penerimaanbarangdetail_id;
                $stokExpDetail->save();
            }

            if ($qtyExpNow == $qty_diterima) {
                $penerimaanbarangdetail = PenerimaanBarangDetail::find($penerimaanbarangdetail_id);
                $penerimaanbarangdetail->status_exp = "1";
                $penerimaanbarangdetail->save();
            }
        } else {
            return redirect()->route('penerimaanbarang.setexp', $penerimaanbarangdetail)->with('status', 'Qty Expired Date Melebihi Qty Pesanan');
        }

        return redirect()->route('penerimaanbarang.setexp', $penerimaanbarangdetail)->with('sukses', 'Expired Date Berhasil Didaftarkan !');
    }

    public function hapusexp(Request $request)
    {
        $data = StokExpDetail::where('id', '=', $request->id)->first();
        $id = $request->id;

        return view('pembelian.penerimaanbarang._confirmDeleteExp', compact('id'));
    }

    public function destroy_exp(Request $request)
    {
        $id = $request->id;

        $stokExpDetail = StokExpDetail::find($id);
        $penerimaanbarangdetail_id =  $stokExpDetail->id_pb_detail;
        $stokExp_id = $stokExpDetail->stok_exp_id;
        $qtyDetail  = $stokExpDetail->qty;

        StokExpDetail::destroy($id);

        $stokExp = StokExp::find($stokExp_id);
        $stokMain = $stokExp->qty;
        $stokSisa = $stokMain - $qtyDetail;
        $penerimaanbarangdetail = PenerimaanBarangDetail::find($penerimaanbarangdetail_id);
        //dd($stokSisa);
        if ($stokSisa >= 0) {
            //masih ada sisa stok, boleh dihapus
            $stokExp->qty = $stokSisa;
            $stokExp->save();

            $penerimaanbarangdetail->status_exp = "0";
            $penerimaanbarangdetail->save();
            return redirect()->route('penerimaanbarang.setexp', $penerimaanbarangdetail)->with('sukses', 'Data berhasil di hapus !');
        } else {
            //stok jadi minus, dilarang hapus
            $pesan = "Data tidak dapat dihapus, stok sudah terpakai! (" .  $stokSisa . ")";
            return redirect()->route('penerimaanbarang.setexp', $penerimaanbarangdetail)->with('status',  $pesan);
        }
    }

    public function delete(Request $request)
    {
        $data = PenerimaanBarang::where('id', '=', $request->id)->get()->first();
        $id = $request->id;
        $status_pb_id = $data->status_pb_id;
        if ($status_pb_id == 2) {
            $can_delete = "NO";
        } else {

            $can_delete = "YES";
        }

        return view('pembelian.penerimaanbarang._confirmDelete', compact('id', 'can_delete'));
    }

    public function destroy(Request $request)
    {
        $tglNow = Carbon::now()->format('Y-m-d');
        $id = $request->id;
        $penerimaanbarang = PenerimaanBarang::find($id);
        $penerimaanbarang_kode = $penerimaanbarang->kode;
        $pesanan_pembelian_id = $penerimaanbarang->pesanan_pembelian_id;
        //validasi :
        $jmlExp = StokExpDetail::where('id_pb', '=', $id)->count();
        //dd($jmlExp);
        if ($jmlExp > 0) {
            return redirect()->route('penerimaanbarang.index')->with('gagal', 'Gagal Menghapus Penerimaan Barang, Silahkan hapus data expired date terlebih dahulu !');
        }

        $detailPB = PenerimaanBarangDetail::where('penerimaan_barang_id', '=', $id)->get();
        foreach ($detailPB as $a) {
            //update stok
            $product = new Product;
            $product = Product::find($a->product_id);
            $stok = $product->stok;
            $hpp = $product->hpp;
            $product->stok = $stok - $a->qty;
            $product->save();

            $pesanan_pembelian_detail_id = $a->pesanan_pembelian_detail_id;
            $stok_baru = $stok - $a->qty;
            //input inv trans
            //######### start add INV TRANS ############
            $inventoryTrans = new InventoryTransaction;
            $inventoryTrans->tanggal = $tglNow;
            $inventoryTrans->product_id = $a->product_id;
            $inventoryTrans->qty = ($a->qty * -1);
            $inventoryTrans->stok = $stok_baru;
            $inventoryTrans->hpp = $hpp;
            $inventoryTrans->jenis = "PB (DEL)";
            $inventoryTrans->jenis_id = $penerimaanbarang_kode;
            $inventoryTrans->save();
            //######### end add INV TRANS ############

            //############# start update Qty Sisa PO #############
            $detailPOupdate = new PesananPembelianDetail;
            $detailPOupdate = PesananPembelianDetail::find($a->pesanan_pembelian_detail_id);
            $detailPOupdate->qty_sisa +=  $a->qty;
            $detailPOupdate->save();
            //############# end update Qty Sisa PO #############

        }


        $penerimaanbarang->deleted_by = Auth::user()->id;
        $penerimaanbarang->save();
        PenerimaanBarang::destroy($request->id);

        $detailPB->each->delete();

        //############# start update status PO #############
        $jmlPBinPO = PenerimaanBarang::where('pesanan_pembelian_id', '=', $pesanan_pembelian_id)->count();
        if ($jmlPBinPO > 0) {
            $status = "3";
        } else {
            $status = "2";
        }
        $POmain = PesananPembelian::find($pesanan_pembelian_id);
        $POmain->status_po_id = $status;
        $POmain->save();
        //############# end update status PO #############

        return redirect()->route('penerimaanbarang.index')->with('status', 'Data Penerimaan Barang Berhasil Dihapus !');
    }

    public function show(PenerimaanBarang $penerimaanbarang)
    {
        $title = "Penerimaan Barang Detail";
        $penerimaanbarangdetails = PenerimaanBarangDetail::with('products')
            ->where('penerimaan_barang_id', '=', $penerimaanbarang->id)->get();
        $listExp = StokExpDetail::where('id_pb', '=', $penerimaanbarang->id)->get();
        return view('pembelian.penerimaanbarang.show', compact('title', 'listExp', 'penerimaanbarang', 'penerimaanbarangdetails'));
    }
}
