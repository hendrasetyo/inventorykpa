<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceProduk;
use App\Models\MaintenanceSebelumKondisi;
use App\Models\MaintenanceSetelahKondisi;
use App\Models\tempSebelumKondisi;
use App\Models\tempSetelahKondisi;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:teknisi-list',['only' => ['index','datatable'] ]);
        $this->middleware('permission:teknisi-create', ['only' => ['create','store']]);
        $this->middleware('permission:teknisi-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:teknisi-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $title = 'Maintenance Produk';
        return view('maintenanceproduk.index',compact('title'));
    }

    public function datatable(Request $request)
    {
        $maintenance = MaintenanceProduk::all();
        dd($maintenance);

        return DataTables::of($maintenance)
                ->addIndexColumn()
                ->editColumn('tanggal', function (MaintenanceProduk $kj) {
                    return $kj->tanggal ? with(new Carbon($kj->tanggal))->format('d F Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('kunjungansales.partial._form-action',[
                        'id' => $id
                    ]);
                })
                ->make(true);
    }


    // ============================================= CREATE =================================================
    public function create()
    {
       $title = 'Perawatan Produk';
       tempSebelumKondisi::where('user_id',auth()->user()->id)->delete();
       tempSetelahKondisi::where('user_id',auth()->user()->id)->delete();

       return view('maintenanceproduk.create',compact('title'));
    }

    // ############################################ BEFORE ##################################################
    public function submitBefore(Request $request)
    {
        try {
            tempSebelumKondisi::create([
                'nama_alat' => $request->nama_alat,
                'no_seri' => $request->no_seri,
                'keluhan' => $request->keluhan,
                'user_id' => auth()->user()->id
            ]);
    
            return response()->json('Data Berhasil Di Inputkan');
        } catch (Exception $th) {
            return response()->json($th->getMessage());
        }
       
    }

    public function editBefore(Request $request)
    {
        $id = $request->id;
        $tempBefore = tempSebelumKondisi::where('id',$id)->first();
        return view('maintenanceproduk.modal._form-before-edit-action',compact('tempBefore'));
    }

    public function updateBefore(Request $request)
    {
        
        tempSebelumKondisi::where('id',$request->id)->update([
            'nama_alat' => $request->nama_alat,
            'no_seri' => $request->no_seri,
            'keluhan' => $request->keluhan,
        ]);

        return response()->json('Data Berhasil Di Ubah');
    }

    public function deleteBefore(Request $request)
    {
        try {
            $id = $request->id_temp;
            tempSebelumKondisi::where('id',$id)->delete();

            return response()->json('Data Berhasil Dihapus');
        } catch (Exception $th) {
            return response()->json($th->getMessage());
        }
    }

    public function tabelBefore(Request $request)
    {
        $tempBefore = tempSebelumKondisi::where('user_id',auth()->user()->id)->get();
        
        return view('maintenanceproduk.tabel.tabel-before-add',compact('tempBefore'));
    }

    // ########################################## AFTER ########################################################

    public function submitAfter(Request $request)
    {
        try {
            tempSetelahKondisi::create([
                'nama_sparepart' => $request->nama_sparepart,
                'qty' => $request->qty,
                'pekerjaan' => $request->pekerjaan,
                'user_id' => auth()->user()->id
            ]);
    
            return response()->json('Data Berhasil Di Inputkan');
        } catch (Exception $th) {
            return response()->json($th->getMessage());
        }
    }

    public function tabelAfter()
    {
        $tempAfter = tempSetelahKondisi::where('user_id',auth()->user()->id)->get();
        
        return view('maintenanceproduk.tabel.tabel-after-add',compact('tempAfter'));
    }

    public function editAfter(Request $request)
    {
        $id = $request->id;
        $tempafter = tempSetelahKondisi::where('id',$id)->first();
        return view('maintenanceproduk.modal._form-after-edit-action',compact('tempafter'));
    }

    public function updateAfter(Request $request)
    {
        tempSetelahKondisi::where('id',$request->id)->update([
            'nama_sparepart' => $request->nama_sparepart,
            'qty' => $request->qty,
            'pekerjaan' => $request->pekerjaan,
        ]);

        return response()->json('Data Berhasil Di Ubah');
    }

    public function deleteAfter(Request $request)
    {
        try {
            $id = $request->id_temp;
            tempSetelahKondisi::where('id',$id)->delete();

            return response()->json('Data Berhasil Dihapus');
        } catch (Exception $th) {
            return response()->json($th->getMessage());
        }
    }

    public function store(Request $request)
    {
        
        DB::beginTransaction();
        try {
            $tempBefore = tempSebelumKondisi::where('user_id',auth()->user()->id)->get();
            $tempAfter = tempSetelahKondisi::where('user_id',auth()->user()->id)->get();

            $tanggal = Carbon::parse(now())->format('Y-m-d');
            $tanggal_pengerjaan = $tanggal;
            $tanggal_selesai_pengerjaan = $tanggal;  

            if ($request->tanggal <> null) {
                $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
            }

            if ($request->tanggal_pengerjaan) {
                $tanggal_pengerjaan = Carbon::parse($request->tanggal_pengerjaan)->format('Y-m-d');
            }

            if ($request->tanggal_selesai_pengerjaan) {
                $tanggal_pengerjaan = Carbon::parse($request->tanggal_selesai_pengerjaan)->format('Y-m-d');
            }

            $maintenance = MaintenanceProduk::create([
                'nama_lab' => $request->nama_lab,
                'pemohon' => $request->pemohon,
                'bagian' => $request->bagian,
                'telepon' => $request->telepon,
                'tanggal' => $tanggal,
                'alamat' => $request->alamat,
                'tanggal_dikerjakan' => $tanggal_pengerjaan,
                'tanggal_selesai_dikerjakan' => $tanggal_selesai_pengerjaan,
                'tempat_pengerjaan' => $request->lokasi_pengerjaan,
                'saran' => $request->saran
            ]);

            foreach ($tempBefore as $value) {
                MaintenanceSebelumKondisi::create([
                    'maintenance_id' => $maintenance->id,
                    'nama_alat' => $value->nama_alat,
                    'no_seri' => $value->no_seri,
                    'keluhan' => $value->keluhan
                ]);
            }

            foreach ($tempAfter as $item) {
                MaintenanceSetelahKondisi::create([
                    'maintenance_id'=> $maintenance->id,
                    'nama_sparepart' => $item->nama_sparepart,
                    'qty' => $item->qty,
                    'pekerjaan' => $item->pekerjaan  
                ]);
            }

            $tempAfter->delete();
            $tempBefore->delete();

            DB::commit();
            return redirect()->route('maintenanceproduk.index')->with('sukses','Data Berhasil Ditambahkan');
            
        } catch (Exception $th) {
            return back()->with('error',$th->getMessage());
        }
    }


}
