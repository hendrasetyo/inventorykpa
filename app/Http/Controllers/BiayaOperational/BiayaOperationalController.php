<?php

namespace App\Http\Controllers\BiayaOperational;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BiayaOperational;
use App\Models\JenisBiaya;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BiayaOperationalController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:biayaoperational-list');
        $this->middleware('permission:biayaoperational-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:biayaoperational-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:biayaoperational-delete', ['only' => ['destroy']]);
    }

   
    public function index()
    {
        $title = "Biaya Operational";

        $biayaoperational = BiayaOperational::with(['jenisbiaya','bank'])->orderByDesc('id');

        if (request()->ajax()) {
            return DataTables::of($biayaoperational)
                ->addIndexColumn()
                ->addColumn('tanggal', function (BiayaOperational $pb) {                    
                    return $pb->tanggal ? with(new Carbon($pb->tanggal))->format('d-F-Y') : '';
                })
                ->addColumn('jenis_biaya', function (BiayaOperational $pb) {
                    return $pb->jenisbiaya->nama;
                })
                ->addColumn('nominal', function (BiayaOperational $pb) {
                    return  number_format($pb->nominal , 0, ',', '.');
                })
                ->addColumn('request', function (BiayaOperational $pb) {
                    return $pb->request;
                })
                ->addColumn('sumberdana', function (BiayaOperational $pb) {
                    return $pb->bank->nama;
                })
                ->addColumn('keterangan', function (BiayaOperational $pb) {
                    return $pb->keterangan;
                })
                ->addColumn('action', function ($row) {                    
                    $editUrl = route('biayaoperational.edit', ['biayaoperational' => $row->id]);                    
                    $id = $row->id;
                    $status = $row->status_pb_id;
                    return view('biayaoperational._formAction', compact('editUrl','id'));
                })
                ->make(true);
        }
        
        return view('biayaoperational.index',compact('title'));
    }

   
    public function create()
    {
        $title = "Tambah Biaya Operational";
        $jenisbiaya = JenisBiaya::get();
        $bank = Bank::get();
        $count = 0;
        return view('biayaoperational.create',compact('jenisbiaya','bank','title','count'));
    }

  
    public function store(Request $request)
    {        
            $data = $request->all();
        
            BiayaOperational::create($data);
           
            return redirect()->route('biayaoperational.index')->with('status','Biaya Operational berhasil ditambahkan');                
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $title = 'Ubah Biaya Operational';
        $biayaoperational = BiayaOperational::findOrFail($id);
        $jenisbiaya = JenisBiaya::get();
        $bank = Bank::get();

        return view('biayaoperational.edit',compact(
            'title',
            'biayaoperational',
            'jenisbiaya',
            'bank'
        ));
    }

   
    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        
        try {          
            $biaya = BiayaOperational::findOrFail($id);
                        
            $biaya->update($request->all());

            DB::commit();
            return redirect()->route('biayaoperational.index')->with('status','Biaya Operational berhasil ditambahkan');

        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('biayaoperational.index')->with('gagal',$th->getMessage());            
        }
    }

    public function delete(Request $request)
    {
        $data = BiayaOperational::where('id', '=', $request->id)->first();
        $id = $request->id;        

        return view('biayaoperational._confirmDelete', compact('id'));
    }
    
   
    public function destroy(Request $request)
    {
        $biaya = BiayaOperational::findOrFail($request->id);
        $biaya->delete();

        return redirect()->route('biayaoperational.index')->with('status','Biaya Operational berhasil dhapus');
    }
}
