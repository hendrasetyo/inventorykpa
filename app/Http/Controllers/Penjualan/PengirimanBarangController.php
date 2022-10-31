<?php

namespace App\Http\Controllers\Penjualan;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\TempSj;
use App\Models\Product;
use App\Models\StokExp;
use App\Traits\CodeTrait;

use Illuminate\Http\Request;
use App\Models\StokExpDetail;
use App\Models\PengirimanBarang;
use App\Models\PesananPenjualan;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\PengirimanBarangDetail;
use App\Models\PesananPenjualanDetail;

class PengirimanBarangController extends Controller
{
    use CodeTrait;
    function __construct()
    {
        $this->middleware('permission:pengirimanbarang-list');
        $this->middleware('permission:pengirimanbarang-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pengirimanbarang-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pengirimanbarang-delete', ['only' => ['destroy']]);
    }

    public function index()
    {


        $title = "Pengiriman Barang";
        $pengirimanbarang = PengirimanBarang::with(['customers',  'statusSJ', 'so'])->orderByDesc('id');

        if (request()->ajax()) {
            return Datatables::of($pengirimanbarang)
                ->addIndexColumn()
                ->addColumn('customer', function (PengirimanBarang $sj) {
                    return $sj->customers->nama;
                })
                ->addColumn('kode_so', function (PengirimanBarang $sj) {
                    return $sj->so->kode;
                })
                ->addColumn('status', function (PengirimanBarang $sj) {
                    return $sj->statusSJ->nama;
                })
                ->editColumn('tanggal', function (PengirimanBarang $sj) {
                    return $sj->tanggal ? with(new Carbon($sj->tanggal))->format('d-m-Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('pengirimanbarang.edit', ['pengirimanbarang' => $row->id]);                    
                    $expUrl = route('pengirimanbarang.inputexp', ['pengirimanbarang' => $row->id]);
                    $showUrl = route('pengirimanbarang.show', ['pengirimanbarang' => $row->id]);
                    $id = $row->id;
                    $status = $row->status_sj_id;
                    return view('penjualan.pengirimanbarang._formAction', compact('editUrl', 'showUrl', 'id', 'status', 'expUrl'));
                })
                ->make(true);
        }


        return view('penjualan.pengirimanbarang.index', compact('title'));
    }

    public function listso()
    {
        $title = "Daftar Pesanan Penjualan";
        $pesananpenjualans = PesananPenjualan::with('customers', 'statusSO')
            ->where('status_so_id', '<=', '3')
            ->where('status_so_id', '<>', '1')
            ->get();

        if (request()->ajax()) {
            return Datatables::of($pesananpenjualans)
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
                    $pilihUrl = route('pengirimanbarang.create', ['pesananpenjualan' => $row->id]);
                    $id = $row->id;
                    return view('penjualan.pengirimanbarang._pilihAction', compact('pilihUrl', 'id'));
                })
                ->make(true);
        }

        //dd($pesananpenjualan);
        return view('penjualan.pengirimanbarang.listso', compact('title', 'pesananpenjualans'));
        
    }

    public function create(PesananPenjualan $pesananpenjualan)
    {
        $title = "Pengiriman Barang";
        //delete temp
        $deletedTempDetil = TempSj::where('user_id', '=', Auth::user()->id)->delete();
        $deletedTempDetil = TempSj::where('created_at', '<', Carbon::today())->delete();


        //ambil list item SO untuk dimasukkan ke Pengiriman
        $id_so = $pesananpenjualan->id;
        $SOdetails = PesananPenjualanDetail::with('products')
            ->where('pesanan_penjualan_id', '=', $id_so)->get();

        return view('penjualan.pengirimanbarang.create', compact('title', 'pesananpenjualan', 'SOdetails'));
    }

    public function setbarang(Request $request)
    {

        $product = PesananPenjualanDetail::with('products')->where('id', '=', $request->id)->get()->first();
        $mode = "new";
        return view('penjualan.pengirimanbarang._setbarang', compact('product', 'mode'));
    }

    public function loadtempsj(Request $request)
    {
        $tempsj = TempSj::with(['products'])
            ->where('user_id', '=', Auth::user()->id)
            ->get();

        return view('penjualan.pengirimanbarang._temptabelsj', compact('tempsj'));
    }

    public function inputtempsj(Request $request)
    {
        $id_detail = $request->detail_id;
        $qty_kirim = $request->qty;
        $keterangan = $request->keterangan;

        $detailSO = PesananPenjualanDetail::with('products')->where('id', '=', $id_detail)->get()->first();
        $product_id = $detailSO->product_id;
        $qty_pesanan = $detailSO->qty;
        $satuan = $detailSO->satuan;
        $qty_sisa = $detailSO->qty_sisa;
        $qty_sisa_kirim = $qty_sisa - $qty_kirim;

        $product = Product::find($product_id);

        //dd($product);
        $stok = $product->stok;
        //dd($stok);
        
        //validasi
        //1. cek item sudah dimasukkan apa belum
        $jmlItem = TempSj::where('product_id', '=', $product_id)->where('user_id',auth()->user()->id)->count();
        
        if ($qty_kirim > 0) {
            if ($qty_kirim <= $stok) {
                if ($jmlItem == 0) {
                    //2. cek qty yg diinput berlebihan/tidak
                    if ($qty_kirim <= $qty_sisa) {
                        $datas['pesanan_penjualan_detail_id'] = $id_detail;
                        $datas['product_id'] = $product_id;
                        $datas['qty'] = $qty_kirim;
                        $datas['qty_sisa'] = $qty_sisa;
                        $datas['qty_pesanan'] = $qty_pesanan;
                        $datas['satuan'] = $satuan;
                        $datas['keterangan'] = $keterangan;
                        $datas['user_id'] = Auth::user()->id;
                        TempSj::create($datas);
                    } else {
                        $request->session()->flash('status', 'Qty melebihi pesanan, periksa kembali inputan anda!');
                    }
                } else {
                    $request->session()->flash('status', 'Produk sudah diinputkan, silahkan periksa kembali inputan anda!');
                }
            } else {
                $request->session()->flash('status', 'Stok tidak mencukupi!' . print_r($product));
            }
        } else {
            $request->session()->flash('status', 'Qty tidak boleh nol!');
        }
    }

    public function destroy_detail(Request $request)
    {
        $id = $request->id;
        TempSj::destroy($id);
    }

    public function editbarang(Request $request)
    {
        $item = TempSj::where('id', '=', $request->id)->get()->first();
        $id_product = $item->product_id;
        $pesanan_penjualan_detail_id = $item->pesanan_penjualan_detail_id;
        $product = new PesananPenjualanDetail;
        $product = PesananPenjualanDetail::with('products')->where('id', '=', $pesanan_penjualan_detail_id)->get()->first();
        $mode = "edit";
        return view('penjualan.pengirimanbarang._setbarang', compact('mode', 'item', 'product'));
    }

    public function updatebarang(Request $request)
    {
        $id = $request->id;
        $so_detail_id = $request->so_detail_id;
        $qty_kirim = $request->qty;
        $keterangan = $request->keterangan;
        $product_id = $request->product_id;

        $temp = TempSj::find($id);
        $qty_pesanan = $temp->qty_pesanan;
        $qty_sisa = $temp->qty_sisa;

        $product = Product::find($product_id);
        $stok = $product->stok;

        if ($qty_kirim <= $stok) {
            if ($qty_kirim <= $qty_sisa) {
                if ($qty_kirim > 0) {
                    $temp->qty = $qty_kirim;
                    $temp->keterangan =  $keterangan;

                    $temp->save();
                } else {
                    $request->session()->flash('status', 'Qty tidak boleh nol !');
                }
            } else {
                $request->session()->flash('status', 'Qty melebihi sisa pesanan, periksa kembali inputan anda!');
            }
        } else {
            $request->session()->flash('status', 'Stok tidak mencukupi !');
        }
    }
    public function store(Request $request, PesananPenjualan $pesananpenjualan)
    {

        $request->validate([
            'tanggal' => ['required'],
        ]);

        $datas = $request->all();
        $tanggal = $request->tanggal;
        if ($tanggal <> null) {
            $tanggal = Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');
        }
        $pesanan_penjualan_id = $pesananpenjualan->id;
        $customer_id = $pesananpenjualan->customer_id;

        $customer_name = Customer::findOrFail($customer_id)->first();

        $dataTemp = TempSj::where('user_id', '=', Auth::user()->id)->get();
        $jmlTemp = $dataTemp->count();
        if ($jmlTemp < 1) {
            return redirect()->route('pengirimanbarang.index')->with('gagal', 'Tidak ada barang yang diinputkan, Pengiriman Barang Gagal Disimpan!');
        }


        $kode = $this->getKodeTransaksi("pengiriman_barangs", "SJ");
        $datas['kode'] = $kode;
        $datas['tanggal'] = $tanggal;
        $datas['pesanan_penjualan_id'] = $pesanan_penjualan_id;
        $datas['customer_id'] = $customer_id;
        $datas['status_sj_id'] = "1";

        $id_sj = PengirimanBarang::create($datas)->id;

        //isi detail
        foreach ($dataTemp as $a) {
            /////// calkulasi HPP  ///////
            $detailPesanan = PesananPenjualanDetail::find($a->pesanan_penjualan_detail_id);
            $hargajual = $detailPesanan->hargajual;
            $diskon_persen = $detailPesanan->diskon_persen;
            $diskon_rp = $detailPesanan->diskon_rp;
            $totaldiskon = ($hargajual * ($diskon_persen / 100)) + $diskon_rp;
            $hargajual_fix = $hargajual - $totaldiskon;

            $product_id = $a->product_id;
            $product = new Product;
            $product = Product::find($product_id);
            $stok_lama = $product->stok;
            $hpp = $product->hpp;
            $status_exp = $product->status_exp;
            if ($status_exp == 1) {
                $status_exp_detil = 0;
            } else {
                $status_exp_detil = 1;
            }

            $stok_baru = $stok_lama - $a->qty;
            $product->stok = $stok_baru;
            $product->save();
            ////////// end hpp //////////

            // ########## start input detail ###########
            $detail = new PengirimanBarangDetail;
            $detail->tanggal = $tanggal;
            $detail->pengiriman_barang_id = $id_sj;
            $detail->pesanan_penjualan_id = $pesanan_penjualan_id;
            $detail->pesanan_penjualan_detail_id = $a->pesanan_penjualan_detail_id;
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
            // $product = new Product;
            // $product = Product::find($product_id)->first();
            // $product->stok = $stok_baru;
            // $product->hpp = $hpp;
            // $product->save();
            //######### end update stok ################

            //######### start add INV TRANS ############
            $inventoryTrans = new InventoryTransaction;
            $inventoryTrans->tanggal = $tanggal;
            $inventoryTrans->product_id = $product_id;
            $inventoryTrans->qty = (0 - $a->qty);
            $inventoryTrans->stok = $stok_baru;
            $inventoryTrans->hpp = $hpp;
            $inventoryTrans->jenis = "SJ";
            $inventoryTrans->jenis_id = $kode;
            $inventoryTrans->jenis_id = $kode;
            $inventoryTrans->customer=$customer_name->nama;
            

            $inventoryTrans->save();
            //######### end add INV TRANS ############

            //############# start update Qty Sisa SO #############
            $detailSOupdate = new PesananPenjualanDetail;
            $detailSOupdate = PesananPenjualanDetail::find($a->pesanan_penjualan_detail_id);
            $detailSOupdate->qty_sisa = ($a->qty_sisa - $a->qty);
            $detailSOupdate->save();
            //############# end update Qty Sisa SO #############
        }
        //############# start update status SO #############
        $totalPesananSO = PesananPenjualanDetail::where('pesanan_penjualan_id', '=', $pesanan_penjualan_id)->sum('qty');
        $totalSisaSO = PesananPenjualanDetail::where('pesanan_penjualan_id', '=', $pesanan_penjualan_id)->sum('qty_sisa');
        $terkirim = $totalPesananSO - $totalSisaSO;

        if ($terkirim == $totalPesananSO) {
            $status = "4";
        } else {
            $status = "3";
        }
        $SOmain = PesananPenjualan::find($pesanan_penjualan_id);
        $SOmain->status_so_id = $status;
        $SOmain->save();
        //############# end update status SO #############

        return redirect()->route('pengirimanbarang.index')->with('status', 'Pengiriman barang berhasil dibuat !');
    }


    public function inputexp(PengirimanBarang $pengirimanbarang)
    {
        $title = "Pengaturan Expired Date";
        $pengirimanbarang_id =  $pengirimanbarang->id;
        $detailItem = PengirimanBarangDetail::where('pengiriman_barang_id', '=', $pengirimanbarang_id)->get();
        // dd($detailItem);
        return view('penjualan.pengirimanbarang.inputexp', compact('pengirimanbarang', 'title', 'detailItem'));
    }

    public function setexp(PengirimanBarangDetail $pengirimanbarangdetail)
    {
        $title = "Pengaturan Expired Date";
        $pengirimanbarangdetail_id = $pengirimanbarangdetail->id;
        $pengirimanbarang_id = $pengirimanbarangdetail->pengiriman_barang_id;
        $pengirimanbarang = PengirimanBarang::find($pengirimanbarang_id);
        $listExp = StokExpDetail::with('stockExp')->where('id_sj_detail', '=', $pengirimanbarangdetail_id)->get();        
        return view('penjualan.pengirimanbarang.setexp', compact('pengirimanbarangdetail', 'title', 'listExp', 'pengirimanbarang'));
    }
    public function listexp(PengirimanBarangDetail $pengirimanbarangdetail)
    {
        $title = "Pengaturan Expired Date";
        $pengirimanbarangdetail_id = $pengirimanbarangdetail->id;
        $pengirimanbarang_id = $pengirimanbarangdetail->pengiriman_barang_id;
        $pengirimanbarang = PengirimanBarang::find($pengirimanbarang_id);
        $product_id = $pengirimanbarangdetail->product_id;
        $stokExp = StokExp::where('product_id', '=', $product_id)
            ->where('qty', '<>', '0')->get();
        //dd($stokExp);
        return view('penjualan.pengirimanbarang.listexp', compact('pengirimanbarangdetail', 'title', 'stokExp', 'pengirimanbarang'));
    }
    public function formsetexp(StokExp $stokExp, PengirimanBarangDetail $pengirimanbarangdetail)
    {
        $title = "Form Pengaturan Expired Date";
        $pengirimanbarangdetail_id = $pengirimanbarangdetail->id;
        $pengirimanbarang_id = $pengirimanbarangdetail->pengiriman_barang_id;
        $product_id = $stokExp->product_id;
        return view('penjualan.pengirimanbarang.formexp', compact('pengirimanbarangdetail', 'stokExp', 'title'));
    }

    public function saveexp(Request $request, StokExp $stokExp, PengirimanBarangDetail $pengirimanbarangdetail)
    {
        $request->validate([

            'qty' => ['required'],
        ]);

        $datas = $request->all();
        $qty = $request->qty;

        if ($qty < 1) {
            return redirect()->route('pengirimanbarang.setexp', $pengirimanbarangdetail)->with('status', 'Qty Harus Lebih dari Nol (0)!');
        }

        $pengirimanbarangdetail_id = $pengirimanbarangdetail->id;
        $pengirimanbarang_id = $pengirimanbarangdetail->pengiriman_barang_id;
        $product_id = $stokExp->product_id;
        $stokExp_id = $stokExp->id;
        $tanggal = $stokExp->tanggal;

        $stok = $stokExp->qty;
        $qty_kirim = $pengirimanbarangdetail->qty;

        //get jumlah qty di exp data
        $totalQtyExp = (StokExpDetail::where('id_sj_detail', '=', $pengirimanbarangdetail_id)->sum('qty')) * -1;

        $qtyExpNow = $totalQtyExp + $qty;

        if ($qtyExpNow <= $qty_kirim) {
            if ($qty <= $stok) {
                //ada data, tinggal update stok
                $stokExp =  StokExp::find($stokExp_id);
                $stokExp->qty -= $qty;
                $stokExp->save();

                //insert detail
                $stokExpDetail = new StokExpDetail;
                $stokExpDetail->tanggal = $tanggal;
                $stokExpDetail->stok_exp_id = $stokExp_id;
                $stokExpDetail->product_id = $product_id;
                $stokExpDetail->qty = ($qty * -1);
                $stokExpDetail->id_sj = $pengirimanbarang_id;
                $stokExpDetail->id_sj_detail = $pengirimanbarangdetail_id;
                $stokExpDetail->save();

                if ($qtyExpNow == $qty_kirim) {
                    $pengirimanbarangdetail = PengirimanBarangDetail::find($pengirimanbarangdetail_id);
                    $pengirimanbarangdetail->status_exp = "1";
                    $pengirimanbarangdetail->save();
                }

                return redirect()->route('pengirimanbarang.setexp', $pengirimanbarangdetail)->with('sukses', 'Expired Date Berhasil Didaftarkan !');
            } else {
                return redirect()->route('pengirimanbarang.setexp', $pengirimanbarangdetail)->with('status', 'Stok Tidak Mencukupi!');
            }
        } else {
            return redirect()->route('pengirimanbarang.setexp', $pengirimanbarangdetail)->with('status', 'Qty Expired Date Melebihi Qty Pesanan');
        }
    }

    public function hapusexp(Request $request)
    {
        $data = StokExpDetail::where('id', '=', $request->id)->first();
        $id = $request->id;

        return view('penjualan.pengirimanbarang._confirmDeleteExp', compact('id'));
    }

    public function destroy_exp(Request $request)
    {
        $id = $request->id;

        $stokExpDetail = StokExpDetail::find($id);
        $pengirimanbarangdetail_id =  $stokExpDetail->id_sj_detail;

        $stokExp_id = $stokExpDetail->stok_exp_id;
        $qtyDetail  = ($stokExpDetail->qty) * -1;
        StokExpDetail::destroy($id);

        $stokExp = StokExp::find($stokExp_id);
        $stokExp->qty += $qtyDetail;
        $stokExp->save();

        $pengirimanbarangdetail = PengirimanBarangDetail::find($pengirimanbarangdetail_id);
        $pengirimanbarangdetail->status_exp = "0";
        $pengirimanbarangdetail->save();
        return redirect()->route('pengirimanbarang.setexp', $pengirimanbarangdetail)->with('sukses', 'Data berhasil di hapus !');
    }

    public function delete(Request $request)
    {
        $data = PengirimanBarang::where('id', '=', $request->id)->get()->first();
        $id = $request->id;
        $status_sj_id = $data->status_sj_id;
        if ($status_sj_id == 2) {
            $can_delete = "NO";
        } else {

            $can_delete = "YES";
        }

        return view('penjualan.pengirimanbarang._confirmDelete', compact('id', 'can_delete'));
    }

    public function destroy(Request $request)
    {
        $tglNow = Carbon::now()->format('Y-m-d');
        $id = $request->id;
        $pengirimanbarang = PengirimanBarang::find($id);
        $customer = Customer::findOrFail($pengirimanbarang->customer_id);
        
        $pengirimanbarang_kode = $pengirimanbarang->kode;
        $pesanan_penjualan_id = $pengirimanbarang->pesanan_penjualan_id;



        //validasi :
        $jmlExp = StokExpDetail::where('id_sj', '=', $id)->count();
        //dd($jmlExp);
        
        if ($jmlExp > 0) {
            return redirect()->route('pengirimanbarang.index')->with('gagal', 'Gagal Menghapus Pengiriman Barang, Silahkan hapus data expired date terlebih dahulu !');
        }

        $detailSJ = PengirimanBarangDetail::where('pengiriman_barang_id', '=', $id)->get();        
        foreach ($detailSJ as $a) {
            //update stok
            $product = new Product;
            $product = Product::find($a->product_id);
            $stok = $product->stok;
            $hpp = $product->hpp;
            $product->stok = $stok + $a->qty;
            $product->save();

            $pesanan_penjualan_detail_id = $a->pesanan_penjualan_detail_id;
            $stok_baru = $stok + $a->qty;

            //input inv trans
            //######### start add INV TRANS ############
            $inventoryTrans = new InventoryTransaction;
            $inventoryTrans->tanggal = $tglNow;
            $inventoryTrans->product_id = $a->product_id;
            $inventoryTrans->qty = $a->qty;
            $inventoryTrans->stok = $stok_baru;
            $inventoryTrans->hpp = $hpp;
            $inventoryTrans->jenis = "SJ (DEL)";
            $inventoryTrans->jenis_id = $pengirimanbarang_kode;
            $inventoryTrans->customer = $customer->nama;

            $inventoryTrans->save();
            //######### end add INV TRANS ############

            //############# start update Qty Sisa SO #############
            $detailSOupdate = new PesananPenjualanDetail;
            $detailSOupdate = PesananPenjualanDetail::find($a->pesanan_penjualan_detail_id);
            $detailSOupdate->qty_sisa +=  $a->qty;
            $detailSOupdate->save();
            //############# end update Qty Sisa SO #############

        }


        $pengirimanbarang->deleted_by = Auth::user()->id;
        $pengirimanbarang->save();
        PengirimanBarang::destroy($request->id);

        $detailSJ->each->delete();

        //############# start update status PO #############
        $jmlSJinSO = PengirimanBarang::where('pesanan_penjualan_id', '=', $pesanan_penjualan_id)->count();
        
        if ($jmlSJinSO > 0) {
            
            $status = "3";
        } else {            
            $status = "2";
        }        
        $SOmain = PesananPenjualan::find($pesanan_penjualan_id);
        $SOmain->status_so_id = $status;
        $SOmain->save();
        //############# end update status PO #############

        return redirect()->route('pengirimanbarang.index')->with('status', 'Data Pengiriman Barang Berhasil Dihapus !');
    }

    public function show(PengirimanBarang $pengirimanbarang)
    {
        $title = "pengiriman Barang Detail";
        $pengirimanbarangdetails = PengirimanBarangDetail::with('products')
            ->where('pengiriman_barang_id', '=', $pengirimanbarang->id)->get();
        $listExp = StokExpDetail::where('id_sj', '=', $pengirimanbarang->id)->get();
        return view('penjualan.pengirimanbarang.show', compact('title', 'listExp', 'pengirimanbarang', 'pengirimanbarangdetails'));
    }

    public function print_a5(PengirimanBarang $pengirimanbarang)
    {
        $title = "Print Surat Jalan";
        $pengirimanbarangdetails = PengirimanBarangDetail::with('products')
            ->where('pengiriman_barang_id', '=', $pengirimanbarang->id)->get();
        $jmlBaris  = $pengirimanbarangdetails->count();
        $perBaris = 7;
        $totalPage = ceil($jmlBaris / $perBaris);
        $listExp = StokExpDetail::with('stockExp')->where('id_sj', '=', $pengirimanbarang->id)->get();
        //dd($listExp);
        $data = [
            'totalPage' => $totalPage,
            'perBaris' => $perBaris,
            'date' => date('m/d/Y'),
            'listExp' => $listExp,
            'pengirimanbarang' => $pengirimanbarang,
            'pengirimanbarangdetails' => $pengirimanbarangdetails
        ];

        $pdf = PDF::loadView('penjualan.pengirimanbarang.print_a5', $data)->setPaper('a5', 'landscape');;
        return $pdf->download($pengirimanbarang->kode.'.pdf');

        //return view('penjualan.fakturpenjualan.print_a4', compact('title',  'totalPage'));
    }

    public function showData($id)
    {
        $pengirimanbarang = PengirimanBarang::where('kode',$id)->first();
        
        $title = "pengiriman Barang Detail";
        $pengirimanbarangdetails = PengirimanBarangDetail::with('products')
            ->where('pengiriman_barang_id', '=', $pengirimanbarang->id)->get();            
        $listExp = StokExpDetail::where('id_sj', '=', $pengirimanbarang->id)->get();

        return view('penjualan.pengirimanbarang.show', compact('title', 'listExp', 'pengirimanbarang', 'pengirimanbarangdetails'));
    }
}

