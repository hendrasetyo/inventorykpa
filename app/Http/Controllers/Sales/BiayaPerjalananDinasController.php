<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\HRD\Karyawan;
use App\Models\Sales\BiayaAkomodasi;
use App\Models\Sales\BiayaPerjalananDinas;
use App\Models\Sales\CashAdvance;
use App\Models\Sales\PerjalananDinas;
use App\Traits\CodeTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class BiayaPerjalananDinasController extends Controller
{
    use CodeTrait;
    public function index ($id)
    {
        $title = 'Biaya Perjalanan Dinas';
        $karyawan = Karyawan::with(['jabatan'])->where('id', auth()->user()->karyawan_id)->first();
        $id_dinas = $id;

        // savebiayadinas 
        $biayadinas = BiayaPerjalananDinas::where('dinas_id',$id_dinas)->first();        

        if (!$biayadinas) {
            $biayadinas = BiayaPerjalananDinas::create([
                'dinas_id' => $id_dinas,
                'keterangan' => null
            ]);
            
            $id = $biayadinas->id;
        }else{
            $id = $biayadinas->id;
        }
        
        $perjalanan = PerjalananDinas::where('dinas_id',$id_dinas)->get();        
        return view('sales.biayaperjalanandinas.create',compact('title','karyawan','id','perjalanan','biayadinas'));
    }

    public function  submitAkomodasi(Request $request)
    {
       $dinas = PerjalananDinas::where('id',$request->perjalanan)->first();

       $totalbiaya = $request->biaya_hotel +  $request->biaya_transportasi +  $request->biaya_makan + $request->biaya_laundry 
                    + $request->biaya_entertainment + $request->biaya_lainya;

       BiayaAkomodasi::create([
            'biaya_perjalanan_dinas_id' => $request->id,
            'perjalanandinas_id' => $request->perjalanan,            
            'biaya_hotel' => $request->biaya_hotel,
            'biaya_transportasi' => $request->biaya_transportasi,
            'biaya_makan' => $request->biaya_makan,
            'biaya_laundry' => $request->biaya_laundry,
            'biaya_entertainment' => $request->biaya_entertainment,
            'biaya_lainya' => $request->biaya_lainya,
            'total_biaya' => $totalbiaya
       ]);

       return  response()->json('Data Berhasil Disimpan');

    }

    public function tableAkomodasi (Request $request)
    {        
       $akomodasi = BiayaAkomodasi::where('biaya_perjalanan_dinas_id',$request->id)->with('perjalanandinas')->get();
       return view('sales.biayaperjalanandinas.tabel.tabel-before-add',compact('akomodasi'));       
    }


    public function deleteAkomodasi (Request $request)
    {        
        $akomodasi = BiayaAkomodasi::where('id',$request->id)->delete();
        return response()->json('Data berhasil dihapus');

    }

    public function editAkomodasi (Request $request)
    {
        $biayaperjalanandinas = BiayaPerjalananDinas::where('id',$request->dinas_id)->first();
        $perjalanan = PerjalananDinas::where('dinas_id',$biayaperjalanandinas->dinas_id)->get();     

        $akomodasi = BiayaAkomodasi::where('id',$request->id)->first();

        return view('sales.biayaperjalanandinas.modal._form-before-edit-action',compact('perjalanan','akomodasi'));

    }

    public function updateAkomodasi (Request $request)
    {
        $totalbiaya = $request->biaya_hotel +  $request->biaya_transportasi +  $request->biaya_makan 
                      + $request->biaya_laundry + $request->biaya_entertainment
                      + $request->biaya_lainya;

        BiayaAkomodasi::where('id' , $request->id)->update([               
             'perjalanandinas_id' => $request->perjalanan,         
             'biaya_hotel' => $request->biaya_hotel,
             'biaya_transportasi' => $request->biaya_transportasi,
             'biaya_makan' => $request->biaya_makan,
             'biaya_laundry' => $request->biaya_laundry,
             'biaya_entertainment' => $request->biaya_entertainment,
             'biaya_lainya' => $request->biaya_lainya,
             'total_biaya' => $totalbiaya
        ]);

        return response()->json('Data Berhasil Diubah');
    }

    public function hitungAkomodasi (Request $request)
    {
     
        $totalakomodasi = BiayaAkomodasi::where('biaya_perjalanan_dinas_id',$request->id)->sum('total_biaya');

        return number_format($totalakomodasi, 0, ',', '.');
    }

    public function submitKasBon (Request $request)
    {        
        $kasbon = CashAdvance::create([
            'biaya_perjalanan_dinas_id' => $request->id,
            'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
            'nominal' => $request->nominal
        ]);    

        return response()->json('Data Berhasil Ditambahkan');

    }

    public function tableKasBon (Request $request)
    {
       $kasbon = CashAdvance::where('biaya_perjalanan_dinas_id',$request->id)->get();

       return view('sales.biayaperjalanandinas.tabel.tabel-after-add',compact('kasbon'));
    }

    public function editKasBon (Request $request)
    {
       $kasbon = CashAdvance::where('id',$request->id)->first();

       return view('sales.biayaperjalanandinas.modal._form-after-edit-action',compact('kasbon'));

    }

    public function updateKasBon (Request $request)
    {
        $kasbon = CashAdvance::where('id',$request->id)->update([            
            'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
            'nominal' => $request->nominal
        ]);    

        return response()->json('Data Berhasil Ditambahkan');
    }

    public function deleteKasBon (Request $request)
    {
        CashAdvance::where('id',$request->id)->delete();

        return response()->json('Data Berhasil Dihapus');
    }   


    public function hitungKasBon (Request $request)
    {
        $kasbon = CashAdvance::where('biaya_perjalanan_dinas_id',$request->id)->sum('nominal');

        return number_format($kasbon, 0, ',', '.');
    }

    public function store (Request $request)
    {        
       $kasbon = BiayaPerjalananDinas::where('id',$request->dinas_id)->update([
            'keterangan' => $request->keterangan
       ]);

       return redirect()->route('perjalanandinas.index');
    }

    public function print ($id)
    {
        $title = 'Biaya Perjalanan Dinas';

        $biayadinas = BiayaPerjalananDinas::with(['cashadvance','biayaakomodasi.perjalanandinas','dinas.user'])->where('id',$id)->first();
                    
        $countPerjalanan = $biayadinas->cashadvance->count();
        $countEntertain = $biayadinas->biayaakomodasi->count();
    
        $karyawan = Karyawan::with('jabatan')->where('id',$biayadinas->dinas->user->karyawan_id)->first();
    
        if ($countPerjalanan < $countEntertain) {
          $jmlBaris = $countEntertain;
        } else {
          $jmlBaris = $countPerjalanan;
        }
    
        $perBaris = 13;
        $totalPage = ceil($jmlBaris / $perBaris);

        $cashadvance = CashAdvance::where('biaya_perjalanan_dinas_id',$id)->sum('nominal');
        $akomodasi = BiayaAkomodasi::where('biaya_perjalanan_dinas_id',$id)->sum('total_biaya');

        $total = $cashadvance - $akomodasi;
    
        $data = [
          'totalPage' => $totalPage,
          'perBaris' => $perBaris,
          'date' => date('d/m/Y'),
          'biayadinas' => $biayadinas,
          'karyawan' => $karyawan,
          'akomodasi' => $akomodasi,
          'cashadvance' => $cashadvance,
          'total' => $total
        ];

      

        // dd($data);
    
        
        //   return view('sales.biayaperjalanandinas.print', [
        //       'title' => $title,
        //       'totalPage' => $totalPage,
        //       'totalPage' => $totalPage,
        //       'perBaris' => $perBaris,
        //       'date' => date('d/m/Y') ,
        //       'data' => $data,
        //       'karyawan' => $karyawan
        //   ]);
    
          $pdf = PDF::loadView('sales.biayaperjalanandinas.print', $data)->setPaper('legal', 'portrait');
          return $pdf->download('perjalanandinas.pdf');

        

    }
}
