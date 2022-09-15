<?php

namespace App\Http\Controllers\Pembayaran;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Piutang;
use App\Traits\CodeTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\PembayaranPiutang;
use App\Http\Controllers\Controller;
use App\Models\FakturPenjualan;
use App\Models\LogToleransi;
use Illuminate\Support\Facades\Auth;

class PembayaranPiutangController extends Controller
{
    use CodeTrait;
    function __construct()
    {
        $this->middleware('permission:pembayaranpiutang-list');
        $this->middleware('permission:pembayaranpiutang-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pembayaranpiutang-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pembayaranpiutang-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = "Pembayaran Piutang";
        $pembayaranpiutang = PembayaranPiutang::with(['customers',  'piutangs', 'banks', 'FakturSO']);

        if (request()->ajax()) {
            return Datatables::of($pembayaranpiutang)
                ->addIndexColumn()
                ->addColumn('customers', function (PembayaranPiutang $ph) {
                    return $ph->customers->nama;
                })
                ->addColumn('faktur_so', function (PembayaranPiutang $ph) {
                    return $ph->FakturSO->kode;
                })
                ->addColumn('banks', function (PembayaranPiutang $ph) {
                    return $ph->banks->nama;
                })
                ->editColumn('nominal', function (PembayaranPiutang $ph) {
                    return $ph->nominal ? with(number_format($ph->nominal, 0, ',', '.')) : '';
                })
                ->editColumn('tanggal', function (PembayaranPiutang $ph) {
                    return $ph->tanggal ? with(new Carbon($ph->tanggal))->format('d-m-Y') : '';
                })
                ->addColumn('action', function ($row) {
                    //$editUrl = route('fakturpembelian.edit', ['fakturpembelian' => $row->id]);
                    //$showUrl = route('pembayaranpiutang.show', ['pembayaranpiutang' => $row->id]);
                    $showUrl = "";
                    $id = $row->id;
                    $status = "";
                    return view('pembayaran.pembayaranpiutang._formAction', compact('id', 'status', 'showUrl'));
                })
                ->make(true);
        }


        return view('pembayaran.pembayaranpiutang.index', compact('title'));
    }

    public function listpiutang()
    {
        $title = "Daftar Piutang";
        $piutangs = Piutang::with('customers', 'fakturSO')
            ->where('status', '=', '1')
            ->get();

        if (request()->ajax()) {
            return Datatables::of($piutangs)
                ->addIndexColumn()
                ->addColumn('customers', function (Piutang $pb) {
                    return $pb->customers->nama;
                })
                ->addColumn('faktur_so', function (Piutang $pb) {
                    return $pb->FakturSO->kode;
                })
                ->editColumn('tanggal', function (Piutang $pb) {
                    return $pb->tanggal ? with(new Carbon($pb->tanggal))->format('d-m-Y') : '';
                })
                ->editColumn('total', function (Piutang $pb) {
                    return $pb->total ? with(number_format($pb->total, 0, ',', '.')) : '';
                })
                ->editColumn('dibayar', function (Piutang $pb) {
                    return $pb->dibayar ? with(number_format($pb->dibayar, 0, ',', '.')) : '0';
                })
                ->editColumn('sisa', function (Piutang $pb) {
                    $sisa = $pb->total - $pb->dibayar;
                    return $sisa ? with(number_format($sisa, 0, ',', '.')) : '0';
                })
                ->editColumn('tanggal_top', function (Piutang $pb) {                    
                    return $pb->tanggal_top ? with(new Carbon($pb->tanggal_top))->format('d-m-Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $pilihUrl = route('pembayaranpiutang.create', ['piutang' => $row->id]);
                    $id = $row->id;
                    return view('pembayaran.pembayaranpiutang._pilihAction', compact('pilihUrl', 'id'));
                })
                ->make(true);
        }

        //dd($pesananpembelian);
        return view('pembayaran.pembayaranpiutang.listpiutang', compact('title', 'piutangs'));
    }
    public function create(Piutang $piutang)
    {
        $title = "Pembayaran Piutang";
        $pembayaranpiutang = new PembayaranPiutang;
        $banks = Bank::get();
        return view('pembayaran.pembayaranpiutang.create', compact('title', 'pembayaranpiutang', 'piutang', 'banks'));
    }

    public function store(Request $request, Piutang $piutang)
    {
        $request->validate([
            'tanggal' => ['required'],
            'nominal' => ['required'],
            'bank_id' => ['required'],
        ]);

        $datas = $request->all();
        $tanggal = $request->tanggal;
        if ($tanggal <> null) {
            $tanggal = Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');
        }

        $total_piutang   = $piutang->total;
        $dibayar        = $piutang->dibayar;
        $sisa           = $total_piutang - $dibayar;

        $nominal = str_replace('.', '', $request->nominal) * 1;
        $dibayar_baru = $dibayar + $nominal;

        $toleransi = $dibayar_baru - $total_piutang ;
              
        if ($toleransi >= 500 || $toleransi<=500) {
            $status = '2';
        } else {
            $status = '1';
        }       

        //insert pembayaran
        $datas['tanggal'] = $tanggal;
        $datas['customer_id'] = $piutang->customer_id;
        $datas['faktur_penjualan_id'] = $piutang->faktur_penjualan_id;
        $datas['piutang_id'] = $piutang->id;
        $datas['bank_id'] = $request->bank_id;
        $datas['nominal'] = $nominal;
        $datas['keterangan'] = $request->keterangan;
        PembayaranPiutang::create($datas);

        //update Piutang
        $datapiutang = Piutang::find($piutang->id);
        $datapiutang->status = $status;
        $datapiutang->dibayar = $dibayar_baru;
        $datapiutang->save();

        $faktur = FakturPenjualan::where('id',$piutang->faktur_penjualan_id)->first();

        if ($status == '2') {
            LogToleransi::create([
                'tanggal' => $tanggal,                
                'rupiah' => $toleransi,
                'jenis' => 'Piutang',
                'jenis_id' => $faktur->kode, 
            ]);
        }

        return redirect()->route('pembayaranpiutang.index')->with('status', 'Pembayaran Piutang Berhasil Dibuat !');
    }

    public function show(Request $request)
    {
        $pembayaranpiutang = PembayaranPiutang::with('FakturSO', 'customers', 'banks')
            ->where('id', '=', $request->id)->get()->first();

        return view('pembayaran.pembayaranpiutang._showDetail', compact('pembayaranpiutang'));
    }

    public function delete(Request $request)
    {
        $data = PembayaranPiutang::where('id', '=', $request->id)->get()->first();
        $id = $request->id;
        return view('pembayaran.pembayaranpiutang._confirmDelete', compact('id'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $pembayaranpiutang = PembayaranPiutang::find($id);
        $piutang_id = $pembayaranpiutang->piutang_id;
        $nominal = $pembayaranpiutang->nominal;

        $data_piutang = Piutang::find($piutang_id);
        $data_piutang->dibayar -= $nominal;
        $data_piutang->status = "1";
        $data_piutang->save();

        $pembayaranpiutang->deleted_by = Auth::user()->id;
        $pembayaranpiutang->save();
        PembayaranPiutang::destroy($request->id);

        return redirect()->route('pembayaranpiutang.index')->with('status', 'Pembayaran piutang Berhasil Dihapus !');
    }
}
