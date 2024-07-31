<?php

namespace App\Http\Controllers\HRD;

use App\Exports\AbsensiExport;
use App\Http\Controllers\Controller;
use App\Imports\AbsensiImport;
use App\Models\HRD\Absensi;
use App\Models\HRD\Karyawan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class   AbsensiController extends Controller
{
    public function index ()
    {        

        $karyawan = Karyawan::get();
        $title = 'Absensi';
        $bulan =  [];
        for ($i = 1; $i <=12; $i++) {
            $databulan = '1-'.$i.'-2023';
            $bulan[] = [
                'nama' => Carbon::parse($databulan)->format('F') ,
                'id' => $i
            ];         
        }

        return view('hrd.absensi.index',compact('title','bulan','karyawan'));
    }

    public function import (Request $request)
    {
        Excel::import(new AbsensiImport, $request->file('file_import'));    
        return back();
    }

    public function datatable (Request $request)
    {
        $absensi = DB::table('absensi as ab')
                ->join('karyawan as k','ab.karyawan_id','=','k.id')                
                ->where('ab.deleted_at','=',null); 
                
                if ($request->year) {
                    $res=$absensi->whereYear('ab.tanggal',$request->year);       
                }else{
                    $res=$absensi;
                }
        
                if ($request->month !== 'All')  {
                    $bulanawal =  $request->month - 1;
                    $tanggalawal = $request->year .'-'. $bulanawal . '-' . 29 ;
                    $tanggalakhir = $request->year .'-'. $request->month . '-' . 28 ;

                    $data=$res->whereDate('tanggal','>=',$tanggalawal)
                              ->whereDate('tanggal','<=',$tanggalakhir);       
                }else{
                    $data=$res;
                }

                if ($request->karyawan == 'All') {
                    $karyawan = $data;
                }else{
                    $karyawan = $data->where('ab.karyawan_id',$request->karyawan);
                }
        
        $data = $karyawan->select('ab.id','ab.tanggal','k.nama','ab.clock_in','ab.clock_out','ab.work_time','ab.status')
                        ->orderBy('id','desc')
                        ->get();                       
        
        return DataTables::of($absensi)
            ->addIndexColumn()
            ->editColumn('nama', function ($absensi) {
                return $absensi->nama;
            })  
            ->editColumn('tanggal', function ($absensi) {
                return Carbon::parse($absensi->tanggal)->format('d/m/Y');
            }) 
            ->editColumn('clock_in', function ($absensi) {
                return Carbon::parse($absensi->clock_in)->format('H:i');
            })        
            ->editColumn('clock_out', function ($absensi) {
                return Carbon::parse($absensi->clock_out)->format('H:i');
            }) 
            ->editColumn('work_time', function ($absensi) {
                return Carbon::parse($absensi->work_time)->format('H:i');
            }) 
            ->editColumn('status', function ($absensi) {
                $status = $absensi->status;
                return view('hrd.absensi.partial.status' ,compact('status')) ;
            })        
            ->addColumn('action', function ($row) {
                $id = $row->id;
                return view('hrd.absensi.partial.action', compact('id'));
            })
            ->make(true);
    }

    public function export (Request $request)
    {
        $data = $request->all();        
        return Excel::download(new AbsensiExport($data), 'absensi.xlsx');
    }

    public function edit ($id)
    {        
        $absensi = Absensi::where('id',$id)->with('karyawan')->first();        
        $title = 'Absensi';

        // dd($absensi);

        return view('hrd.absensi.edit',compact('absensi','title'));
    }

    public function update (Request $request , $id)
    {
       Absensi::where('id',$id)->update([            
            'clock_in' => Carbon::parse($request->clock_in)->format('H:i') ,
            'clock_out' => Carbon::parse($request->clock_out)->format('H:i') ,
            'work_time' => Carbon::parse($request->clock_out)->format('H:i') ,
            'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d') ,
            'status' => $request->status,
            'keterangan' => $request->keterangan
       ]);

       return redirect()->route('absensi.index');
    }

    public function delete (Request $request)
    {
        Absensi::where('id',$request->id)->delete();
        return response()->json('Data Berhasil Dihapus');
    }

    public function status(Request $request)
    {
        $absensi = Absensi::where('id',$request->id)->first();
        return view('hrd.absensi.modal.status',compact('absensi'));

    }
    

    public function inputstatus (Request $request)
    {
       $absensi = Absensi::where('id',$request->id)->update([
        'status' => $request->status
       ]);

       return response()->json('Data Berhasil Diubah');
    }
    
}
