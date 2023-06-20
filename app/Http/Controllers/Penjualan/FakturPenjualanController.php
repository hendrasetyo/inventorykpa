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
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Models\FakturPenjualanDetail;
use App\Models\LogNoFakturPajak;
use App\Models\NoFakturPajak;
use App\Models\NoKPA;
use App\Models\PengirimanBarangDetail;
use App\Models\PesananPenjualanDetail;
use App\Models\TempBiaya;
use Exception;
use Illuminate\Support\Facades\DB;

use function App\Traits\textKoma;
use function App\Traits\wordOfNumber;

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
                ->editColumn('no_kpa', function (FakturPenjualan $sj) {
                    return $sj->no_kpa;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('fakturpenjualan.edit', ['fakturpenjualan' => $row->id]);
                    $showUrl = route('fakturpenjualan.show', ['fakturpenjualan' => $row->id]);
                    $id = $row->id;
                    $status = $row->status_sj_id;

                    return view('penjualan.fakturpenjualan._formAction', compact('id', 'status', 'showUrl','editUrl'));
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
        $title = "Faktur Penjualan";
        $fakturpenjualan = new FakturPenjualan;
        $tglNow = Carbon::now()->format('d-m-Y');

        //delete temp
        $deletedTempDetil = TempFaktursos::where('created_at', '<', Carbon::today())->delete();
        $deletedTempBiaya = TempBiaya::where('created_at', '<', Carbon::today())->delete();
        $deletedTempDetil = TempFaktursos::where('user_id', '=', Auth::user()->id)->delete();
        $deletedTempBiaya = TempBiaya::where('user_id', '=', Auth::user()->id)->delete();        


        //masukkan tempDetil Faktur
        $id_sj = $pengirimanbarang->id;
        $id_so = $pengirimanbarang->pesanan_penjualan_id;

        

        $SJdetails = PengirimanBarangDetail::where('pengiriman_barang_id', '=', $id_sj)->get();

        // input temp biaya
        $idtempbiaya = TempBiaya::create([
                        'jenis' => 'FJ',
                        'rupiah' => 0,
                        'user_id' => auth()->user()->id,
                        'pengiriman_barang_id' => $id_sj
                    ])->rupiah;
                

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
            $ongkir_det = $ongkir_det + $ongkir;
            $total = $subtotal - $totaldiskon;
            $total_det = $total_det + $total;
          
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
        $total_header = $subtotal_header - $total_diskon_header + $ongkir_header;
        $ppn_header = round(($total_header * ($ppn_so / 100)), 2);
        $grandtotal_header = $total_header + $ppn_header ;

        $nopajak = NoFakturPajak::where('status','Aktif')->get();
        $nokpa = NoKPA::where('status','Aktif')->get();

        return view('penjualan.fakturpenjualan.create', 
                    compact('title', 'FJdetails', 'tglNow', 'fakturpenjualan', 
                    'pengirimanbarang', 'SJdetails', 'subtotal_header', 'ongkir_header', 
                    'total_diskon_header', 'total_header', 'ppn_header', 'grandtotal_header','idtempbiaya',
                    'nopajak','nokpa'));
    }

    public function store(Request $request, PengirimanBarang $pengirimanbarang)
    {
        $request->validate([
            'tanggal' => ['required'],            
        ]);

        $datas = $request->all();
        $tanggal = $request->tanggal;

        $biaya = TempBiaya::where('jenis', '=', "FJ")
                ->where('user_id', '=', Auth::user()->id)
                ->first();

        $biayalainlain = $biaya->rupiah;    

        if ($tanggal <> null) {
            $tanggal = Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');
        }

        $kode = $this->getKodeTransaksi("faktur_penjualans", "FJ");
        $id_sj = $pengirimanbarang->id;
        $id_so = $pengirimanbarang->pesanan_penjualan_id;
        
        $pesanan = PesananPenjualan::where('id',$id_so)->first();
        $tanggal_top = date("Y-m-d", strtotime("+".$pesanan->top." days" . $tanggal));        

        $SJdetails = PengirimanBarangDetail::where('pengiriman_barang_id', '=', $id_sj)->get();        

        // pajak
        $pajak = NoFakturPajak::where('id',$request->pajak_id)->first();

        // nokpa
        $kpa = NoKPA::where('id',$request->kpa_id)->first();


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
        $total_header = $subtotal_header - $total_diskon_header+$ongkir_header;
        $ppn_header = round(($total_header * ($ppn_so / 100)), 2);
        $grandtotal_header = $total_header + $ppn_header  + $biayalainlain;

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
        $datas['no_kpa'] = $kpa->no_kpa;
        $datas['biaya_lain'] = $biayalainlain;
        $datas['pajak_id'] = $pajak->id;
        $datas['no_seri_pajak'] = $request->no_seri_pajak;
        $datas['no_pajak'] = $pajak->no_pajak;
        $idFaktur = FakturPenjualan::create($datas)->id;

        // save di log faktur pajak dan ubah faktur pajak menjadi tidak aktif
        $logpajak = LogNoFakturPajak::create([
            'nofaktur_id' => $pajak->id,
            'jenis' => 'FJ',
            'jenis_id' => $kode
        ]);

        // log no kpa


        // ubah status menjadi tidak aktif
        $pajak->update([
            'status' => 'Tidak Aktif'
        ]);
 
        // // ubah status no kpa menjadi tidak aktif
        // $kpa->update([
        //     'status' => 'Tidak Aktif'
        // ]);

    
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
        $piutang->tanggal_top= $tanggal_top;
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
        

         // save di log faktur pajak dan ubah faktur pajak menjadi tidak aktif
         $logpajak = LogNoFakturPajak::create([
            'nofaktur_id' => $fakturpenjualan->pajak_id,
            'jenis' => 'FJ (DEL)',
            'jenis_id' => $fakturpenjualan->kode
        ]);

        // ubah status menjadi tidak aktif        
        $pajak = NoFakturPajak::where('id',$fakturpenjualan->pajak_id)->update([
            'status' => $request->status_pajak
        ]);

        //hapus Piutang 
        $hapuspiutang = Piutang::where('faktur_penjualan_id', $id)->delete();

        //ubah status PB
        $SJ = PengirimanBarang::find($id_sj);
        $SJ->status_sj_id = 1;
        $SJ->save();

        return redirect()->route('fakturpenjualan.index')->with('status', 'Data Faktur Penjualan Berhasil Dihapus !');
    }

    public function edit(FakturPenjualan $fakturpenjualan)
    {
        $title = "Faktur Penjualan ";
        $fakturpenjualan = FakturPenjualan::where('id',$fakturpenjualan->id)->with([
            'nopajak',
            'SJ',
            'SO'
        ])->first();

        $nopajak = NoFakturPajak::where('status','Aktif')->orWhere('id',$fakturpenjualan->pajak_id)->get(); 
        $nokpa = NoKPA::where('status','Aktif')->get();       

        $FJdetails = FakturPenjualanDetail::with('products')
            ->where('faktur_penjualan_id', '=', $fakturpenjualan->id)->get();

        return view('penjualan.fakturpenjualan.edit', compact('title',  'fakturpenjualan', 'FJdetails','nopajak','nokpa'));
    }

    public function update(Request $request,$id)
    {                

        // dd($request->all());
        DB::beginTransaction();
        try {
             // ambil data dari temp     
             $fj = FakturPenjualan::where('id',$id)->first();

            // ubah status menjadi aktif
            $pajak = NoFakturPajak::where('id',$fj->pajak_id)->update([
                'status' => 'Aktif'
            ]);

            // pajak
            $pajak = NoFakturPajak::where('id',$request->pajak_id)->first();

            // nokpa
            $kpa = NoKPA::where('id',$request->kpa_id)->first();
                           
            $biaya = TempBiaya::where('jenis', '=', "FJ")
                ->where('user_id', '=', Auth::user()->id)
                ->first();


            if ($biaya) {                
                $grandtotal = $fj->grandtotal + $biaya->rupiah - $fj->biaya_lain;
                $rupiah = $biaya->rupiah;

                $biaya->delete();
            }else{
                $grandtotal = $fj->grandtotal;
                $rupiah = $fj->biaya_lain;
            }
                     
            $fj->update([
                'grandtotal' => $grandtotal,
                'no_kpa' => $kpa->no_kpa,
                'pajak_id' => $request->pajak_id,
                'biaya_lain'  => $rupiah,
                'no_seri_pajak' => $request->no_seri_pajak,
                'no_pajak' => $pajak->no_pajak
            ]);

             // ubah status menjadi aktif
             $pajak = NoFakturPajak::where('id',$request->pajak_id)->update([
                'status' => 'Tidak Aktif'
            ]);

            // ubah data yang ada di faktur penjualan    

            
            DB::commit();

            return redirect()->route('fakturpenjualan.index')->with('status', 'Faktur Penjualan berhasil diubah!');
        } catch (Exception $th) {
            return redirect()->route('fakturpenjualan.index')->with('error', $th->getMessage());
        }
       
    }

    public function show(FakturPenjualan $fakturpenjualan)
    {
        $title = "Faktur penjualan Detail";
        $fakturpenjualan = FakturPenjualan::where('id',$fakturpenjualan->id)->with(['nopajak','creator'])->first();
        // dd($fakturpenjualan);
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
        $perBaris = 13;
        $totalPage = ceil($jmlBaris / $perBaris);
        $data = [
            'totalPage' => $totalPage,
            'perBaris' => $perBaris,
            'date' => date('d/m/Y'),
            'fakturpenjualan' => $fakturpenjualan,
            'fakturpenjualandetails' => $fakturpenjualandetails
        ];
        $pdf = PDF::loadView('penjualan.fakturpenjualan.print_a4', $data)->setPaper('a4', 'potrait');;
        return $pdf->download($fakturpenjualan->no_kpa.'-'.$fakturpenjualan->kode.'.pdf');

        // return view('penjualan.fakturpenjualan.print_a4', [
        //     'title' => $title,
        //     'totalPage' => $totalPage,
        //     'totalPage' => $totalPage,
        //     'perBaris' => $perBaris,
        //     'date' => date('d/m/Y'),
        //     'fakturpenjualan' => $fakturpenjualan,
        //     'fakturpenjualandetails' => $fakturpenjualandetails
        // ]);
    }

    public function editCN(FakturPenjualan $fakturpenjualan)
    {
        $title = "Faktur penjualan Detail";
        $fakturpenjualan = FakturPenjualan::where('id',$fakturpenjualan->id)->with('nopajak')->first();
        $fakturpenjualandetails = FakturPenjualanDetail::with('products')
            ->where('faktur_penjualan_id', '=', $fakturpenjualan->id)->get();

        
        return view('penjualan.fakturpenjualan.showCN', compact('title',  'fakturpenjualan', 'fakturpenjualandetails'));
    }

    public function createCN(Request $request,FakturPenjualanDetail $fakturpenjualandetail)
    {
        
        $data = $request->except('_token');        

        $harga1 = $request->cn_persen;        
        $harga = str_replace(',', '.', $harga1) * 1;
        
        $subtotal = $fakturpenjualandetail->subtotal;
        $data['cn_rupiah'] = $subtotal * $harga/100;
        $data['cn_total'] = $data['cn_rupiah'];

        $fakturpenjualandetail->update([
            'cn_persen' => $harga,
            'cn_rupiah' => $data['cn_rupiah'],
            'cn_total' => $data['cn_total']
        ]);  

        $totalCN = FakturPenjualanDetail::where('faktur_penjualan_id',$fakturpenjualandetail->faktur_penjualan_id)->sum('cn_total');      
        FakturPenjualan::where('id',$fakturpenjualandetail->faktur_penjualan_id)->update([
            'total_cn' => $totalCN,
        ]);
                     
        return back();
    }

    public function updateCN(Request $request,FakturPenjualanDetail $fakturpenjualandetail)
    {

        $harga1 = $request->cn_persen;        
        $harga = str_replace(',', '.', $harga1) * 1;  

        $data = $request->except('_token');        
        $subtotal = $fakturpenjualandetail->subtotal;
        $data['cn_rupiah'] = $subtotal * $harga/100;
      
        
        $data['cn_total'] = $data['cn_rupiah'];

        $fakturpenjualandetail->update([
            'cn_persen' => $harga,
            'cn_rupiah' => $data['cn_rupiah'],
            'cn_total' => $data['cn_total']
        ]);   

        $totalCN = FakturPenjualanDetail::where('faktur_penjualan_id',$fakturpenjualandetail->faktur_penjualan_id)->sum('cn_total');
        

        FakturPenjualan::where('id',$fakturpenjualandetail->faktur_penjualan_id)->update([
            'total_cn' => $totalCN
        ]);

       
        
        return back();

    }

    public function editbiaya(Request $request)
    {
        $item = TempBiaya::where('jenis', '=', "FJ")
        ->where('user_id', '=', Auth::user()->id)
        ->get()->first();

        $id_biaya = $item->id;
        $biaya = $item->rupiah;        

        return view('penjualan.fakturpenjualan._setbiaya', compact('id_biaya', 'biaya'));
    }

    public function updatebiaya(Request $request)
    {        
        $id_biaya = $request->id_biaya;        
    
        $biaya = TempBiaya::find($id_biaya);        
        $biaya->rupiah = $request->biaya;
        $biaya->save();                  
    }

    public function hitungbiaya(Request $request)
    {        
        $biaya = TempBiaya::where('jenis', '=', "FJ")
                ->where('user_id', '=', Auth::user()->id)
                ->first();
            
        $total_biaya = $biaya->rupiah;

        if ($total_biaya == 0) {
            return $total_biaya;
        } else {
            return number_format($total_biaya, 2, ',', '.');
        }
    }

    public function hitunggrandtotal(Request $request)
    {
        $grandtotal = $request->grandtotal;
        $biaya = TempBiaya::where('jenis', '=', "FJ")
                ->where('user_id', '=', Auth::user()->id)
                ->first();
    
        $totalgrandtotal = $biaya->rupiah + $grandtotal;

        if ($totalgrandtotal == 0) {
            return $totalgrandtotal;
        } else {
            return number_format($totalgrandtotal, 2, ',', '.');
        }
    }

    public function showdata($id)
    {
        $fakturpenjualan = FakturPenjualan::where('pajak_id',$id)->with('nopajak')->first();
        $title = "Faktur penjualan Detail";
        // $fakturpenjualan = FakturPenjualan::where('id',$fakturpenjualan->id)->with('nopajak')->first();
        // dd($fakturpenjualan);
        $fakturpenjualandetails = FakturPenjualanDetail::with('products')
            ->where('faktur_penjualan_id', '=', $fakturpenjualan->id)->get();


        return view('penjualan.fakturpenjualan.show', compact('title',  'fakturpenjualan', 'fakturpenjualandetails'));
    }



    public function getNoKpa(Request $request)
    {
        try {
            $data = NoFakturPajak::where('id', $request->id)->first();
            return response()->json($data);
        } catch (Exception $th) {
            return response()->json($th->getMessage());
        }
       
    }

    public function kwitansi(FakturPenjualan $fakturpenjualan)
    {
       

        $customer = Customer::where('id',$fakturpenjualan->customer_id)->first();
        
        // // $pattern = "^([0-9]+)$";
        // $textkoma = '';

        $digit=(int)$fakturpenjualan->grandtotal;
        // $koma = $fakturpenjualan->grandtotal - (double)$digit;
        $text = wordOfNumber($fakturpenjualan->grandtotal);
      

        // if ($koma>0) {
        //     $harga2 = str_replace('.', '', round($koma,2));
        //     $array = str_split($harga2);
        //     $datakoma = textKoma($array);
        //     $textkoma='Koma '.implode(' ',$datakoma);
             
        // }
        $responseText = $text;
        
    
        $pdf = PDF::loadView('penjualan.fakturpenjualan.kwitansi',[
            'faktur' => $fakturpenjualan->no_kpa,
            'text' => $responseText,
            'grandtotal' => $fakturpenjualan->grandtotal,
            'customer' => $customer->nama
        ])->setPaper('a4','landscape');


        return $pdf->download('KWIT'.$fakturpenjualan->no_kpa.'-'.$fakturpenjualan->kode.'.pdf');

        // return view('penjualan.fakturpenjualan.kwitansi',[
        //     'faktur' => $fakturpenjualan->no_kpa,
        //     'text' => $responseText,
        //     'grandtotal' => $fakturpenjualan->grandtotal,
        //     'customer' => $customer->nama
        // ]);

       
    }

 
}
