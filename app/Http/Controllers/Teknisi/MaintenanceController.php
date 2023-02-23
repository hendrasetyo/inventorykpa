<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceProduk;
use App\Models\MaintenanceSebelumKondisi;
use App\Models\MaintenanceSetelahKondisi;
use App\Models\tempSebelumKondisi;
use App\Models\tempSetelahKondisi;
use Barryvdh\DomPDF\Facade as PDF;
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
        $maintenance = MaintenanceProduk::with(['creator','updater']);

        return DataTables::of($maintenance)
                ->addIndexColumn()
                ->editColumn('tanggal', function (MaintenanceProduk $kj) {
                    return $kj->tanggal ? with(new Carbon($kj->tanggal))->format('d F Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('maintenanceproduk.partial._action',[
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

            if ($request->tanggal_pengerjaan <> null) {
                $tanggal_pengerjaan = Carbon::createFromFormat('d/m/Y',$request->tanggal_pengerjaan)->format('Y-m-d');
            }

            if ($request->tanggal_selesai_pengerjaan <> null) {
                $tanggal_selesai_pengerjaan = Carbon::createFromFormat('d/m/Y',$request->tanggal_selesai_pengerjaan)->format('Y-m-d');
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

            tempSebelumKondisi::where('user_id',auth()->user()->id)->delete();
            tempSetelahKondisi::where('user_id',auth()->user()->id)->delete();

            DB::commit();

            return redirect()->route('maintenanceproduk.index')->with('sukses','Data Berhasil Ditambahkan');
            
        } catch (Exception $th) {
            return back()->with('error',$th->getMessage());
        }
    }


    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->id;
            $maintenance = MaintenanceProduk::where('id',$id)->with(['sebelumKondisi','setelahKondisi'])->first();
            
            if ($maintenance) {
                $maintenance->sebelumKondisi()->delete();
                $maintenance->setelahKondisi()->delete();
                $maintenance->delete();

                DB::commit();
    
                return response()->json('Data Berhasil Dihapus');
            }else{
                return response()->json('Data Tidak Ditemukan');
            }

        } catch (Exception $th) {
            DB::rollBack();
            return response()->json($th->getMessage());
        }
      

    }

    public function show($id)
    {
        $maintenance = MaintenanceProduk::where('id',$id)->with(['sebelumKondisi','setelahKondisi','creator','updater'])->first();
        $title = 'MAINTENANCE PRODUK';

        if ($maintenance) {
            return view('maintenanceproduk.show',compact('maintenance','title'));
        }else{
            return back()->with('error','Data tidak ditemukan');
        }
    }

    // ########################################## EDIT DATA ######################################################################
    // ========================================== BEFORE =========================================================================

    public function edit($id)
    {
        $maintenance = MaintenanceProduk::where('id',$id)->with(['sebelumKondisi','setelahKondisi','creator','updater'])->first();
        $title = 'MAINTENANCE PRODUK';

        if ($maintenance) {
            return view('maintenanceproduk.edit',compact('maintenance','title'));
        }else{
            return back()->with('error','Data tidak ditemukan');
        }
    }

    public function loadTabelEditBefore(Request $request)
    {
        $tempBefore = MaintenanceSebelumKondisi::where('maintenance_id',$request->id)->get();
        
        return view('maintenanceproduk.tabel.edit.tabel-before-edit',compact('tempBefore'));
    }

    public function EditsubmitBefore(Request $request)
    {
        try {
            MaintenanceSebelumKondisi::create([
                'maintenance_id' => $request->id,
                'nama_alat' => $request->nama_alat,
                'no_seri' => $request->no_seri,
                'keluhan' => $request->keluhan
            ]);
    
            return response()->json('Data Berhasil Di Inputkan');
        } catch (Exception $th) {
            return response()->json($th->getMessage());
        }       
    }

    public function editDataBefore(Request $request)
    {
        $id = $request->id;
        $tempBefore = MaintenanceSebelumKondisi::where('id',$id)->first();
        return view('maintenanceproduk.modal.edit._form-before-edit-action',compact('tempBefore'));
    }

    public function updateDataBefore(Request $request)
    {
        MaintenanceSebelumKondisi::where('id',$request->id)->update([
            'nama_alat' => $request->nama_alat,
            'no_seri' => $request->no_seri,
            'keluhan' => $request->keluhan
        ]);

        return response()->json('Data Berhasil Di Inputkan');
    }

    public function destroyEditBefore(Request $request)
    {
        try {
            $id = $request->id_temp;
            MaintenanceSebelumKondisi::where('id',$id)->delete();

            return response()->json('Data Berhasil Dihapus');
        } catch (Exception $th) {
            return response()->json($th->getMessage());
        }
    }
    // ******************************************* AFTER ***********************************************************

    public function loadTabelEditAfter(Request $request)
    {
        $tempAfter = MaintenanceSetelahKondisi::where('maintenance_id',$request->id)->get();
        
        return view('maintenanceproduk.tabel.edit.tabel-after-edit',compact('tempAfter'));
    }

    public function EditsubmitAfter(Request $request)
    {
        try {
            MaintenanceSetelahKondisi::create([
                'maintenance_id' => $request->id,
                'nama_sparepart' => $request->nama_sparepart,
                'qty' => $request->qty,
                'pekerjaan' => $request->pekerjaan,
            ]);

            return response()->json('Data Berhasil Di Inputkan');
        } catch (Exception $th) {
            return response()->json($th->getMessage());
        }       
    }

    public function editDataAfter(Request $request)
    {
        $id = $request->id;
        $tempafter = MaintenanceSetelahKondisi::where('id',$id)->first();
        return view('maintenanceproduk.modal.edit._form-after-edit-action',compact('tempafter'));
    }

    public function updateDataAfter(Request $request)
    {
        MaintenanceSetelahKondisi::where('id',$request->id)->update([
            'nama_sparepart' => $request->nama_sparepart,
            'qty' => $request->qty,
            'pekerjaan' => $request->pekerjaan,
        ]);

        return response()->json('Data Berhasil Dihapus');
    }

    public function destroyEditAfter(Request $request)
    {
        try {
            $id = $request->id_temp;
            MaintenanceSetelahKondisi::where('id',$id)->delete();

            return response()->json('Data Berhasil Dihapus');
        } catch (Exception $th) {
            return response()->json($th->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        
        $tanggal = Carbon::parse(now())->format('Y-m-d');
        $tanggal_pengerjaan = $tanggal;
        $tanggal_selesai_pengerjaan = $tanggal;  

        if ($request->tanggal !== null) {
            
            $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
        }

        if ($request->tanggal_pengerjaan !==  null) {
            $tanggal_pengerjaan = Carbon::createFromFormat('d/m/Y',$request->tanggal_pengerjaan)->format('Y-m-d');
        }

        if ($request->tanggal_selesai_pengerjaan !==  null) {
            
            $tanggal_selesai_pengerjaan = Carbon::createFromFormat('d/m/Y',$request->tanggal_selesai_pengerjaan)->format('Y-m-d');
            
        }

        $maintenance = MaintenanceProduk::where('id',$id)->update([
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

        return redirect()->route('maintenanceproduk.index')->with('sukses','Data Berhasil Dirubah');
    }

    public function print($id)
    {
        $title = "Print Faktur penjualan";
        $maintenance = MaintenanceProduk::with(['sebelumKondisi','creator','setelahKondisi'])            
            ->where('id', '=', $id)->first();
        $jmlBaris  = $maintenance->count();
        $perBaris = 13;
        $totalPage = ceil($jmlBaris / $perBaris);

        $data = [
            'totalPage' => $totalPage,
            'totalPage' => $totalPage,
            'perBaris' => $perBaris,
            'date' => date('d/m/Y'),
            'maintenance' => $maintenance
        ];
        // dd($data);
        
        $pdf = PDF::loadView('maintenanceproduk.print', $data)->setPaper('legal', 'portrait');
        return $pdf->download('maintenance.pdf');

        // return view('maintenanceproduk.print', [
        //     'title' => $title,
        //     'totalPage' => $totalPage,
        //     'totalPage' => $totalPage,
        //     'perBaris' => $perBaris,
        //     'date' => date('d/m/Y')
        // ]);
    }




}
