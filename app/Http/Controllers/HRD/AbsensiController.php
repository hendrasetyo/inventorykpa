<?php

namespace App\Http\Controllers\HRD;

use App\Exports\AbsensiExport;
use App\Http\Controllers\Controller;
use App\Imports\AbsensiImport;
use App\Models\HRD\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class AbsensiController extends Controller
{
    public function index ()
    {        
        $title = 'Absensi';
        $bulan =  [];
        for ($i = 1; $i <=12; $i++) {
            $databulan = '1-'.$i.'-2023';
            $bulan[] = [
                'nama' => Carbon::parse($databulan)->format('F') ,
                'id' => $i
            ];         
        }

        return view('hrd.absensi.index',compact('title','bulan'));
    }

    public function import (Request $request)
    {
        Excel::import(new AbsensiImport, $request->file('file_import'));    
        return back();
    }

    public function datatable (Request $request)
    {
        $absensi = Absensi::with('karyawan')->get();        
        
        return DataTables::of($absensi)
            ->addIndexColumn()
            ->editColumn('nama', function (Absensi $k) {
                return $k->karyawan->nama;
            })  
            ->editColumn('tanggal', function (Absensi $k) {
                return Carbon::parse($k->tanggal)->format('d/m/Y');
            }) 
            ->editColumn('clock_in', function (Absensi $k) {
                return Carbon::parse($k->clock_in)->format('H:i');
            })        
            ->editColumn('clock_out', function (Absensi $k) {
                return Carbon::parse($k->clock_out)->format('H:i');
            }) 
            ->editColumn('work_time', function (Absensi $k) {
                return Carbon::parse($k->work_time)->format('H:i');
            }) 
            ->editColumn('status', function (Absensi $k) {
                $status = $k->status;
                return view('hrd.absensi.partial.status' ,compact('status')) ;
            })        
            ->addColumn('action', function ($row) {
                $id = $row->id;
                return view('hrd.cuti.partial.action', compact('id'));
            })
            ->make(true);
    }

    public function export (Request $request)
    {
        $data = $request->all();
        // dd($data);
        return Excel::download(new AbsensiExport($data), 'absensi.xlsx');
    }
    
    
}
