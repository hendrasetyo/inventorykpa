<?php

namespace App\Http\Controllers\KunjunganSales;

use App\Http\Controllers\Controller;
use App\Models\KunjunganSales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KunjunganSalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kunjungansales-list',['only' => ['index','datatable'] ]);
        $this->middleware('permission:kunjungansales-create', ['only' => ['create','store']]);
        $this->middleware('permission:kunjungansales-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:kunjungansales-delete', ['only' => ['destroy']]);
        $this->middleware('permission:kunjungansales-show', ['only' => ['show']]);

    }

    public function index()
    {
        $title = 'Kunjungan Sales';
        return view('kunjungansales.index',compact('title'));
    }

    public function datatable(Request $request)
    {
        $kunjungan = KunjunganSales::where('user_id',auth()->user()->id)->select('id','customer','aktifitas','tanggal')->orderBy('id','desc');

        return DataTables::of($kunjungan)
                ->addIndexColumn()
                ->editColumn('tanggal', function (KunjunganSales $kj) {
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

    public function create()
    {
        $title = 'Kunjungan Sales';
        return view('kunjungansales.create',compact('title'));
    }

    public function store(Request $request)
    {
        $img = $request->file('image');
        $signed = $request->input('signed');
        $nameFile = null;
        $tanggal = Carbon::parse(now())->format('Y-m-d');
       
        if ($img) { 
            // dd($img);           
            $dataFoto =$img->getClientOriginalName();
            $waktu = time();
            $name = $waktu.$dataFoto;
            $nameFile = Storage::putFileAs('kunjungan',$img,$name);            
            $nameFile = $name;

        }

       
        if ($signed) {            
            $folderPath = public_path('ttd/');
        
            $image_parts = explode(";base64,", $request->signed);
                       
            $image_type_aux = explode("image/", $image_parts[0]);
                    
            $image_type = $image_type_aux[1];
                    
            $image_base64 = base64_decode($image_parts[1]);
            $name = uniqid() . '.'.$image_type;
                    
            $file = $folderPath . $name;
            file_put_contents($file, $image_base64);

            $request['ttd'] = $name; 
        }

        KunjunganSales::create([
            'tanggal' => $tanggal,
            'customer' => $request->customer,
            'aktifitas' => $request->aktifitas,
            'ttd' => $request->ttd,
            'image' => $nameFile,
            'user_id' => auth()->user()->id
        ]);


        return redirect()->route('kunjungansales.index');                
    }

    public function show($id)
    {
        $title = 'Kunjungan Sales';
        $kunjungan = KunjunganSales::where('id',$id)->first();
        return view('kunjungansales.show',compact('title','kunjungan'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $kunjungan=KunjunganSales::where('id',$id)->first();

        if ($kunjungan->image) {
            Storage::disk('public')->delete($kunjungan->image);
        }

        if ($kunjungan->ttd) {
            $folderPath = public_path('ttd/');
            unlink($folderPath . $kunjungan->ttd);
        }

        $kunjungan->delete();

        return back ();
        

    }


}
