<?php

namespace App\Http\Controllers\Penjualan;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Piutang;
use App\Traits\CodeTrait;
use Illuminate\Http\Request;
use App\Models\TempFaktursos;
use App\Models\FakturPenjualan;
use App\Models\PengirimanBarang;
use App\Models\PesananPenjualan;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FakturPenjualanDetail;
use App\Models\PengirimanBarangDetail;
use App\Models\PesananPenjualanDetail;


class FakturPenjualanController extends Controller
{
    use CodeTrait;

    function __construct()
    {
        $this->middleware('permission:fakturpenjualan-list');
        $this->middleware('permission:fakturpenjualan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:fakturpenjualan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:fakturpenjualan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "Faktur Penjualan";
        $fakturpenjualan = FakturPenjualan::with(['customers',  'statusFJ', 'so', 'sj'])->orderByDesc('id');

        if (request()->ajax()) {
            return Datatables::of($fakturpenjualan)
                ->addIndexColumn()
                ->addColumn('customer', function (FakturPenjualan $sj) {
                    return $sj->customers->nama;
                })
                ->addColumn('kode_so', function (FakturPenjualan $sj) {
                    return $sj->so->kode;
                })
                ->addColumn('kode_sj', function (FakturPenjualan $sj) {
                    return $sj->sj->kode;
                })

                ->editColumn('tanggal', function (FakturPenjualan $sj) {
                    return $sj->tanggal ? with(new Carbon($sj->tanggal))->format('d-m-Y') : '';
                })
                ->addColumn('action', function ($row) {
                    //$editUrl = route('fakturpembelian.edit', ['fakturpembelian' => $row->id]);
                    $showUrl = route('fakturpenjualan.show', ['fakturpenjualan' => $row->id]);
                    $id = $row->id;
                    $status = $row->status_sj_id;
                    return view('penjualan.fakturpenjualan._formAction', compact('id', 'status', 'showUrl'));
                })
                ->make(true);
        }


        return view('penjualan.fakturpenjualan.index', compact('title'));
    }

    public function listsj()
    {
        $title = "Daftar Pesanan Penjualan";
        $pengirimanbarangs = PengirimanBarang::with('customers', 'statusSJ')
            ->where('status_sj_id', '=', '1')
            ->get();
        if (request()->ajax()) {
            return Datatables::of($pengirimanbarangs)
                ->addIndexColumn()
                ->addColumn('customer', function (PengirimanBarang $pb) {
                    return $pb->customers->nama;
                })
                ->addColumn('status', function (PengirimanBarang $pb) {
                    return $pb->statusSJ->nama;
                })
                ->editColumn('tanggal', function (PengirimanBarang $pb) {
                    return $pb->tanggal ? with(new Carbon($pb->tanggal))->format('d-m-Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $pilihUrl = route('fakturpenjualan.create', ['pengirimanbarang' => $row->id]);
                    $id = $row->id;
                    return view('penjualan.fakturpenjualan._pilihAction', compact('pilihUrl', 'id'));
                })
                ->make(true);
        }

        //dd($pesananpembelian);
        return view('penjualan.fakturpenjualan.listsj', compact('title', 'pengirimanbarangs'));
    }


    public function create(PengirimanBarang $pengirimanbarang)
    {
        $title = "Faktur Pembelian";
        $fakturpenjualan = new FakturPenjualan;
        $tglNow = Carbon::now()->format('d-m-Y');
        //delete temp
        $deletedTempDetil = TempFaktursos::where('created_at', '<', Carbon::today())->delete();
        $deletedTempDetil = TempFaktursos::where('user_id', '=', Auth::user()->id)->delete();

        //masukkan tempDetil Faktur
        $id_sj = $pengirimanbarang->id;
        $id_so = $pengirimanbarang->pesanan_penjualan_id;

        $SJdetails = PengirimanBarangDetail::where('pengiriman_barang_id', '=', $id_sj)->get();

        //start cek status exp date SJ :
        $status_exp_sj = 1;
        foreach ($SJdetails as $s) {
            if ($s->status_exp == 0) {
                $status_exp_sj = 0;
            }
        }
        if ($status_exp_sj == 0) {
            return redirect()->route('fakturpenjualan.listsj')->with('gagal', 'Terdapat Pengiriman Barang Yang Belum Diinputkan Exp. Date! Silahkah hubungi bagian Logistik untuk menginputnya !');
        }
        // end cek status exp date SJ


        $SOdata = PesananPenjualan::find($id_so);
        $ppn_so = $SOdata->ppn;
        $diskon_rupiah_so = $SOdata->diskon_rupiah;
        $diskon_persen_so = $SOdata->diskon_persen;


        $total_det = 0;
        $ongkir_det = 0;
        foreach ($SJdetails as $sj) {
            $temp = new TempFaktursos;

            $sodetail = new PesananPenjualanDetail;
            $sodetail = PesananPenjualanDetail::find($sj->pesanan_penjualan_detail_id);
            $hargajual = $sodetail->hargajual;
            $diskon_persen = $sodetail->diskon_persen;
            $diskon_rp = $sodetail->diskon_rp;
            $ongkir = $sodetail->ongkir;
            $keterangan = $sodetail->keterangan;

            $subtotal = $hargajual * $sj->qty;
            $totaldiskon = (($subtotal * ($diskon_persen / 100)) + $diskon_rp);
            $total = $subtotal - $totaldiskon;
            $total_det = $total_det + $total;
            $ongkir_det = $ongkir_det + $ongkir;

            $temp->product_id = $sj->product_id;
            $temp->pengiriman_barang_id = $sj->pengiriman_barang_id;
            $temp->pengiriman_barang_detail_id = $sj->id;
            $temp->qty = $sj->qty;
            $temp->satuan = $sj->satuan;
            $temp->hargajual = $hargajual;
            $temp->diskon_persen = $diskon_persen;
            $temp->diskon_rp = $diskon_rp;
            $temp->subtotal = $subtotal;
            $temp->total_diskon = $totaldiskon;
            $temp->total = $total;
            $temp->ongkir = $ongkir;
            $temp->keterangan = $keterangan;
            $temp->user_id = Auth::user()->id;
            $temp->save();
        }
        $FJdetails = TempFaktursos::where('pengiriman_barang_id', '=', $id_sj)
            ->where('user_id', '=', Auth::user()->id)->get();
        //dd($FBdetails);
        $subtotal_header = $total_det;
        $ongkir_header = $ongkir_det;
        $total_diskon_header = ($subtotal_header * ($diskon_persen_so / 100)) + $diskon_rupiah_so;
        $total_header = $subtotal_header - $total_diskon_header;
        $ppn_header = round(($total_header * ($ppn_so / 100)), 2);
        $grandtotal_header = $total_header + $ppn_header + $ongkir_header;

        return view('penjualan.fakturpenjualan.create', compact('title', 'FJdetails', 'tglNow', 'fakturpenjualan', 'pengirimanbarang', 'SJdetails', 'subtotal_header', 'ongkir_header', 'total_diskon_header', 'total_header', 'ppn_header', 'grandtotal_header'));
    }

    public function store(Request $request, PengirimanBarang $pengirimanbarang)
    {
        $request->validate([
            'tanggal' => ['required'],
        ]);

        $datas = $request->all();
        $tanggal = $request->tanggal;
        if ($tanggal <> null) {
            $tanggal = Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');
        }

        $kode = $this->getKodeTransaksi("faktur_penjualans", "FJ");
        $id_sj = $pengirimanbarang->id;
        $id_so = $pengirimanbarang->pesanan_penjualan_id;

        $SJdetails = PengirimanBarangDetail::where('pengiriman_barang_id', '=', $id_sj)->get();

        //start cek status exp date SJ :
        $status_exp_sj = 1;
        foreach ($SJdetails as $s) {
            if ($s->status_exp == 0) {
                $status_exp_sj = 0;
            }
        }
        if ($status_exp_sj == 0) {
            return redirect()->route('fakturpenjualan.listsj')->with('gagal', 'Terdapat Pengiriman Barang Yang Belum Diinputkan Exp. Date! Silahkah hubungi bagian Logistik untuk menginputnya !');
        }
        // end cek status exp date SJ

        $SOdata = PesananPenjualan::find($id_so);
        $ppn_so = $SOdata->ppn;
        $diskon_rupiah_so = $SOdata->diskon_rupiah;
        $diskon_persen_so = $SOdata->diskon_persen;
        $sales_id = $SOdata->sales_id;

        $FJdetails = TempFaktursos::where('pengiriman_barang_id', '=', $id_sj)
            ->where('user_id', '=', Auth::user()->id)->get();
        $subtotal_header = TempFaktursos::where('pengiriman_barang_id', '=', $id_sj)
            ->where('user_id', '=', Auth::user()->id)->sum('total');
        //$subtotal_header = $total_det;
        $ongkir_header = TempFaktursos::where('pengiriman_barang_id', '=', $id_sj)
            ->where('user_id', '=', Auth::user()->id)->sum('ongkir');

        $total_diskon_detail = TempFaktursos::where('pengiriman_barang_id', '=', $id_sj)
            ->where('user_id', '=', Auth::user()->id)->sum('total_diskon');

        $total_diskon_header = ($subtotal_header * ($diskon_persen_so / 100)) + $diskon_rupiah_so;
        $total_header = $subtotal_header - $total_diskon_header;
        $ppn_header = round(($total_header * ($ppn_so / 100)), 2);
        $grandtotal_header = $total_header + $ppn_header + $ongkir_header;

        $datas['kode'] = $kode;
        $datas['tanggal'] = $tanggal;
        $datas['customer_id'] = $pengirimanbarang->customer_id;
        $datas['pesanan_penjualan_id'] = $id_so;
        $datas['pengiriman_barang_id'] = $id_sj;
        $datas['status_fakturso_id'] = "1";
        $datas['keterangan'] = $request->keterangan;
        $datas['diskon_rupiah'] = $diskon_rupiah_so;
        $datas['diskon_persen'] = $diskon_persen_so;
        $datas['subtotal'] = $subtotal_header;
        $datas['total_diskon_detail'] = $total_diskon_detail;
        $datas['total_diskon_header'] = $total_diskon_header;
        $datas['total'] = $total_header;
        $datas['grandtotal'] = $grandtotal_header;
        $datas['ppn'] = $ppn_header;
        $datas['ongkir'] = $ongkir_header;
        $datas['sales_id'] = $sales_id;
        $datas['no_kpa'] = $request->no_kpa;
        $datas['no_pajak'] = $request->no_pajak;
        $idFaktur = FakturPenjualan::create($datas)->id;

        //$ongkir_header = $ongkir_det;
        foreach ($FJdetails as $pb) {
            $detil = new FakturPenjualanDetail;
            $detil->faktur_penjualan_id = $idFaktur;
            $detil->pengiriman_barang_detail_id = $pb->pengiriman_barang_detail_id;
            $detil->product_id = $pb->product_id;
            $detil->qty = $pb->qty;
            $detil->satuan = $pb->satuan;
            $detil->hargajual = $pb->hargajual;
            $detil->diskon_persen = $pb->diskon_persen;
            $detil->diskon_rp = $pb->diskon_rp;
            $detil->subtotal = $pb->subtotal;
            $detil->total_diskon = $pb->total_diskon;
            $detil->total = $pb->total;
            $detil->ongkir = $pb->ongkir;
            $detil->keterangan = $pb->keterangan;
            $detil->save();
        }
        #################### update Status PB ##################
        $dataPB = PengirimanBarang::find($id_sj);
        $dataPB->status_sj_id = "2";
        $dataPB->save();
        #################### END update status PB ##############
        #################### update Piutang ##################
        $piutang = new Piutang;
        $piutang->tanggal = $tanggal;
        $piutang->customer_id = $pengirimanbarang->customer_id;
        $piutang->pesanan_penjualan_id = $id_so;
        $piutang->pengiriman_barang_id = $id_sj;
        $piutang->faktur_penjualan_id = $idFaktur;
        $piutang->dpp = $total_header;
        $piutang->ppn = $ppn_header;
        $piutang->total = $grandtotal_header;
        $piutang->dibayar = "0";
        $piutang->status = "1"; //1 = belum lunas ; 2= lunas
        $piutang->save();
        #################### end update Piutang ##################

        return redirect()->route('fakturpenjualan.index')->with('status', 'Faktur Penjualan berhasil dibuat !');
    }

    public function delete(Request $request)
    {
        $data = FakturPenjualan::where('id', '=', $request->id)->get()->first();
        $id = $request->id;

        return view('penjualan.fakturpenjualan._confirmDelete', compact('id'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $fakturpenjualan = FakturPenjualan::find($id);
        $fakturpenjualan->deleted_by = Auth::user()->id;
        $fakturpenjualan->save();
        $id_sj = $fakturpenjualan->pengiriman_barang_id;

        FakturPenjualan::destroy($request->id);
        $detail = FakturPenjualanDetail::where('faktur_penjualan_id', '=', $id)->get();
        foreach ($detail as $d) {
            FakturPenjualanDetail::destroy($d->id);
        }

        //hapus Piutang 
        $hapuspiutang = Piutang::where('faktur_penjualan_id', $id)->delete();

        //ubah status PB
        $SJ = PengirimanBarang::find($id_sj);
        $SJ->status_sj_id = 1;
        $SJ->save();

        return redirect()->route('fakturpenjualan.index')->with('status', 'Data Faktur Penjualan Berhasil Dihapus !');
    }

    public function show(FakturPenjualan $fakturpenjualan)
    {
        $title = "Faktur penjualan Detail";
        $fakturpenjualandetails = FakturPenjualanDetail::with('products')
            ->where('faktur_penjualan_id', '=', $fakturpenjualan->id)->get();
        return view('penjualan.fakturpenjualan.show', compact('title',  'fakturpenjualan', 'fakturpenjualandetails'));
    }

    public function print_a4(FakturPenjualan $fakturpenjualan)
    {
        $title = "Print Faktur penjualan";
        $fakturpenjualandetails = FakturPenjualanDetail::with('products')            
            ->where('faktur_penjualan_id', '=', $fakturpenjualan->id)->get();
        $jmlBaris  = $fakturpenjualandetails->count();
        $perBaris = 20;
        $totalPage = ceil($jmlBaris / $perBaris);
        $data = [
            'totalPage' => $totalPage,
            'perBaris' => $perBaris,
            'date' => date('d/m/Y'),
            'fakturpenjualan' => $fakturpenjualan,
            'fakturpenjualandetails' => $fakturpenjualandetails
        ];
        $pdf = PDF::loadView('penjualan.fakturpenjualan.print_a4', $data)->setPaper('a4', 'potrait');;
        return $pdf->download($fakturpenjualan->kode.'.pdf');

        //return view('penjualan.fakturpenjualan.print_a4', compact('title',  'totalPage'));
    }

    public function editCN(FakturPenjualan $fakturpenjualan)
    {
        $title = "Faktur penjualan Detail";
        $fakturpenjualandetails = FakturPenjualanDetail::with('products')
            ->where('faktur_penjualan_id', '=', $fakturpenjualan->id)->get();

        
        return view('penjualan.fakturpenjualan.showCN', compact('title',  'fakturpenjualan', 'fakturpenjualandetails'));
    }

    public function createCN(Request $request,FakturPenjualanDetail $fakturpenjualandetail)
    {
        // dd($fakturpenjualandetail);
        $data = $request->except('_token');        
        
        $subtotal = $fakturpenjualandetail->subtotal;
        $data['cn_rupiah'] = $subtotal * $data['cn_persen']/100;
        $data['cn_total'] = $data['cn_rupiah'];

        $fakturpenjualandetail->update($data);   

        $fakturPenjualan = FakturPenjualan::where('id',$fakturpenjualandetail->faktur_penjualan_id)->first();
        $totalCNFaktur = $fakturPenjualan->total_cn + $data['cn_total'];        

        $fakturPenjualan->update([
            'total_cn' => $totalCNFaktur
        ]);
                     
        return back();
    }

    public function updateCN(Request $request,FakturPenjualanDetail $fakturpenjualandetail)
    {
        $data = $request->except('_token');        
        $subtotal = $fakturpenjualandetail->subtotal;
        $data['cn_rupiah'] = $subtotal * $data['cn_persen']/100;
        $data['cn_total'] = $data['cn_rupiah'];

        $fakturPenjualan = FakturPenjualan::where('id',$fakturpenjualandetail->faktur_penjualan_id)->first();
        $totalCNFaktur = $fakturPenjualan->total_cn - $fakturpenjualandetail->cn_total + $data['cn_total'];

        $fakturPenjualan->update([
            'total_cn' => $totalCNFaktur
        ]);

        $fakturpenjualandetail->update($data);   

        return back();

    }

 
}
