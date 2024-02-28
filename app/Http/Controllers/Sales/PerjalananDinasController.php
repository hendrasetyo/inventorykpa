<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\HRD\Karyawan;
use App\Models\Sales\BiayaAkomodasi;
use App\Models\Sales\BiayaPerjalananDinas;
use App\Models\Sales\CashAdvance;
use App\Models\Sales\Dinas;
use App\Models\Sales\EntertainDinas;
use App\Models\Sales\PerjalananDinas;
use App\Models\Sales\TempEntertainDinas;
use App\Models\Sales\TempPerjalananDinas;
use App\Traits\CodeTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade as PDF;

class PerjalananDinasController extends Controller
{
  use CodeTrait;
  public function index()
  {
    $title = 'Perjalanan Dinas';
    $dinas = Dinas::where('user_id', auth()->user()->id)->get();

    $count = 0;

    TempPerjalananDinas::where('user_id',auth()->user()->id)->delete();
    TempEntertainDinas::where('user_id',auth()->user()->id)->delete();

    foreach ($dinas as $value) {
      $status = BiayaPerjalananDinas::where('dinas_id', $value->id)->where('status_direktur', 'menunggu')->first();
      if ($status) {
        $count = 1;
      }
    }

    return view('sales.perjalanandinas.index', compact('title', 'count'));
  }

  public function datatable()
  {
      $dinas =  DB::table('dinas as d')
              ->join('users as u', 'u.id', '=', 'd.user_id')              
              ->select('d.id as id', 'u.name as user', 'd.tujuan_dinas as tujuan_dinas', 'd.keterangan as keterangan', 'd.status as status','d.status_direktur as status_direktur'                
              )
              ->where('d.deleted_at', '=', null)              
              ->get();

      $hasil = $dinas;
      return DataTables::of($hasil)
          ->addIndexColumn()
          ->editColumn('user', function ($sj) {
            return $sj->user;
          })
          ->editColumn('tujuan_dinas', function ($sj) {
            return $sj->tujuan_dinas;
          })
          ->editColumn('keterangan', function ($sj) {
            return $sj->keterangan;
          })
          ->editColumn('status', function ($sj) {
            return $sj->status;
          })
          ->editColumn('status_direktur', function ($sj) {
            return $sj->status_direktur ? $sj->status_direktur : '-' ;
          })      
          ->editColumn('action', function ($row) {
            $id = $row->id;
            return view('sales.perjalanandinas.partial._action', compact('id'));
          })
          ->make(true);
  }

  public function create()
  {
    $title = 'Perjalanan Dinas';
    $karyawan = Karyawan::with(['jabatan'])->where('id', auth()->user()->karyawan_id)->first();
    return view('sales.perjalanandinas.create', compact('title', 'karyawan'));
  }


  public function submitDinas(Request $request)
  {
    TempPerjalananDinas::create([
      'user_id' => auth()->user()->id,
      'tujuan' => $request->tujuan,
      'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
      'asal_mana' => $request->asal_mana,
      'waktu_mulai' => Carbon::parse($request->waktu_mulai)->format('H:i'),
      'waktu_selesai' => Carbon::parse($request->waktu_selesai)->format('H:i'),
      'jenis_transportasi' => $request->jenis_transportasi,
      'penyedia_transportasi' => $request->penyedia_transportasi,
      'waktu_berangkat' => Carbon::parse($request->waktu_berangkat)->format('H:i'),
      'nama_hotel' => $request->nama_hotel
    ]);

    return response()->json('Data Berhasil Ditambahkan');
  }

  public function tableDinas()
  {
    $tempDinas = TempPerjalananDinas::where('user_id', auth()->user()->id)->get();

    return view('sales.perjalanandinas.tabel.tabel-before-add', compact('tempDinas'));
  }

  public function editDinas(Request $request)
  {
    $id = $request->id;
    $dinas = TempPerjalananDinas::where('id', $id)->first();

    return view('sales.perjalanandinas.modal._form-before-edit-action', compact('dinas'));
  }

  public function updateDinas(Request $request)
  {
    $dinas =  TempPerjalananDinas::where('id', $request->id)->update([
      'tujuan' => $request->tujuan,
      'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
      'asal_mana' => $request->asal_mana,
      'waktu_mulai' => Carbon::parse($request->waktu_mulai)->format('H:i'),
      'waktu_selesai' => Carbon::parse($request->waktu_selesai)->format('H:i'),
      'jenis_transportasi' => $request->jenis_transportasi,
      'penyedia_transportasi' => $request->penyedia_transportasi,
      'waktu_berangkat' => Carbon::parse($request->waktu_berangkat)->format('H:i'),
      'nama_hotel' => $request->nama_hotel
    ]);

    return response()->json('Data Berhasil Ditambahkan');
  }

  public function deleteDinas(Request $request)
  {
    $id = $request->id;
    TempPerjalananDinas::where('id', $id)->delete();
    return response()->json('Data Berhasil Ditambahkan');
  }

  public function submitEntertain(Request $request)
  {
    TempEntertainDinas::create([
      'user_id' => auth()->user()->id,
      'nama_perusahaan' => $request->nama_perusahaan,
      'nama' => $request->nama,
      'jenis_entertainment' => $request->jenis_entertainment,
      'tujuan_entertainment' => $request->tujuan_entertainment
    ]);

    return response()->json('Data Berhasil Ditambahkan');
  }

  public function tableEntertain()
  {
    $entertain = TempEntertainDinas::where('user_id', auth()->user()->id)->get();
    return view('sales.perjalanandinas.tabel.tabel-after-add', compact('entertain'));
  }

  public function editEntertain(Request $request)
  {
    $entertain = TempEntertainDinas::where('id', $request->id)->first();

    return view('sales.perjalanandinas.modal._form-after-edit-action', compact('entertain'));
  }

  public function updateEntertain(Request $request)
  {
    TempEntertainDinas::where('id', $request->id)->update([
      'nama_perusahaan' => $request->nama_perusahaan,
      'nama' => $request->nama,
      'jenis_entertainment' => $request->jenis_entertainment,
      'tujuan_entertainment' => $request->tujuan_entertainment
    ]);

    return response()->json('Data Berhasil di Ubah');
  }

  public function deleteEntertain(Request $request)
  {
    TempEntertainDinas::where('id', $request->id)->delete();
    return response()->json('Data Berhasil di hapus');
  }


  public function store(Request $request)
  {
    $tempdinas = TempPerjalananDinas::where('user_id', auth()->user()->id)->get();
    $tempEntertain = TempEntertainDinas::where('user_id', auth()->user()->id)->get();

    DB::beginTransaction();
    try {
      $dinas = Dinas::create([
        'user_id' => auth()->user()->id,
        'tujuan_dinas' => $request->tujuan_perjalanan,
        'keterangan' => $request->keterangan,
        'status' => 'Menunggu',
        'status_direktur' => 'Menunggu'
      ]);

      foreach ($tempdinas as $item) {
        PerjalananDinas::create([
          'dinas_id' => $dinas->id,
          'asal_mana' => $item->asal_mana,
          'tujuan' => $item->tujuan,
          'tanggal' => Carbon::parse($item->tanggal)->format('Y-m-d'),
          'waktu_mulai' => Carbon::parse($item->waktu_mulai)->format('H:i'),
          'waktu_selesai' => Carbon::parse($item->waktu_selesai)->format('H:i'),
          'jenis_transportasi' => $item->jenis_transportasi,
          'penyedia_transportasi' => $item->penyedia_transportasi,
          'waktu_berangkat' => Carbon::parse($item->waktu_berangkat)->format('H:i'),
          'nama_hotel' => $item->nama_hotel
        ]);
      }

      foreach ($tempEntertain as $item) {
        EntertainDinas::create([
          'dinas_id' => $dinas->id,
          'nama_perusahaan' => $item->nama_perusahaan,
          'nama' => $item->nama,
          'jenis_entertainment' => $item->jenis_entertainment,
          'tujuan_entertainment' => $item->tujuan_entertainment,
        ]);
      }

      TempPerjalananDinas::where('user_id', auth()->user()->id)->delete();
      TempEntertainDinas::where('user_id', auth()->user()->id)->delete();

      DB::commit();
      return redirect()->route('perjalanandinas.index')->with('success', 'Berhasil Menambahkan Data');
    } catch (Exception $th) {
      DB::rollback();

      return redirect()->route('perjalanandinas.index')->with('success', $th->getMessage());
    }
  }

  // ============================================================== EDIT =============================================================

  public function edit($id)
  {

    $title = 'Perjalanan Dinas';
    $dinas = Dinas::with('user')->where('id', $id)->first();
    $karyawan = Karyawan::with('jabatan')->where('id', $dinas->user->karyawan_id)->first();
    $id = $dinas->id;

    return view('sales.perjalanandinas.edit', compact('title', 'dinas', 'karyawan', 'id'));
  }

  public function tableDinasEdit(Request $request)
  {
    $perjalananDinas = PerjalananDinas::where('dinas_id', $request->id)->get();

    return view('sales.perjalanandinas.tabel.edit.tabel-before-edit', compact('perjalananDinas'));
  }

  public function editDinasEdit(Request $request)
  {
    $dinas = PerjalananDinas::where('id', $request->id)->first();

    return view('sales.perjalanandinas.modal.edit._form-before-edit-action', compact('dinas'));
  }

  public function updateDinasEdit(Request $request)
  {
    $dinas = PerjalananDinas::where('id', $request->id)->update([
      'tujuan' => $request->tujuan,
      'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
      'asal_mana' => $request->asal_mana,
      'waktu_mulai' => Carbon::parse($request->waktu_mulai)->format('H:i'),
      'waktu_selesai' => Carbon::parse($request->waktu_selesai)->format('H:i'),
      'jenis_transportasi' => $request->jenis_transportasi,
      'penyedia_transportasi' => $request->penyedia_transportasi,
      'waktu_berangkat' => Carbon::parse($request->waktu_berangkat)->format('H:i'),
      'nama_hotel' => $request->nama_hotel
    ]);

    return response()->json('Data Berhasil Ditambahkan');
  }

  public function deleteDinasEdit(Request $request)
  {
    $dinas = PerjalananDinas::where('id', $request->id)->delete();

    return response()->json('Data Berhasil dihapus');
  }

  public function submitDinasEdit(Request $request)
  {
    PerjalananDinas::create([
      'dinas_id' => $request->id,
      'tujuan' => $request->tujuan,
      'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
      'asal_mana' => $request->asal_mana,
      'waktu_mulai' => Carbon::parse($request->waktu_mulai)->format('H:i'),
      'waktu_selesai' => Carbon::parse($request->waktu_selesai)->format('H:i'),
      'jenis_transportasi' => $request->jenis_transportasi,
      'penyedia_transportasi' => $request->penyedia_transportasi,
      'waktu_berangkat' => Carbon::parse($request->waktu_berangkat)->format('H:i'),
      'nama_hotel' => $request->nama_hotel
    ]);

    return response()->json('Data Berhasil Ditambahkan');
  }


  public function submitEntertainEdit(Request $request)
  {
    $entertain = EntertainDinas::create([
      'dinas_id' => $request->id,
      'nama_perusahaan' => $request->nama_perusahaan,
      'nama' => $request->nama,
      'jenis_entertainment' => $request->jenis_entertainment,
      'tujuan_entertainment' => $request->tujuan_entertainment,
    ]);

    return response()->json('Data Berhasil ditambahkan');
  }

  public function tableEntertainEdit(Request $request)
  {
    $entertain = EntertainDinas::where('dinas_id', $request->id)->get();
    return view('sales.perjalanandinas.tabel.edit.tabel-after-edit', compact('entertain'));
  }

  public function editEntertainEdit(Request $request)
  {
    $entertain = EntertainDinas::where('id', $request->id)->first();
    return view('sales.perjalanandinas.modal.edit._form-after-edit-action', compact('entertain'));
  }


  public function updateEntertainEdit(Request $request)
  {


    $entertain = EntertainDinas::where('id', $request->id)->update([
      'nama_perusahaan' => $request->nama_perusahaan,
      'nama' => $request->nama,
      'jenis_entertainment' => $request->jenis_entertainment,
      'tujuan_entertainment' => $request->tujuan_entertainment,
    ]);

    return response()->json('Data Berhasil Diubah');
  }

  public function deleteEntertainEdit(Request $request)
  {
    $entertain = EntertainDinas::where('id', $request->id)->delete();
    return response()->json('Data Berhasil Dihapus');
  }

  public function update(Request $request, $id)
  {
    $dinas = Dinas::where('id', $id)->update([
      'tujuan_dinas' => $request->tujuan_perjalanan,
      'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('perjalanandinas.index')->with('Success', 'Data Berhasil Dihapus');
  }



  public function delete(Request $request)
  {
  }

  public function show($id)
  {
    $dinas = Dinas::where('id', $id)->with(['perjalanandinas', 'entertaindinas', 'user'])->first();

    $title = 'Perjalanan Dinas';
    return view('sales.perjalanandinas.show', compact('dinas', 'title'));
  }

  public function print($id)
  {
    $title  = 'Print Perjalanan Dinas';
    $dinas = Dinas::where('id', $id)->with(['user', 'perjalanandinas', 'entertaindinas'])->first();

    $countPerjalanan = $dinas->perjalanandinas->count();
    $countEntertain = $dinas->entertaindinas->count();

    $karyawan = Karyawan::with('jabatan')->where('id', $dinas->user->karyawan_id)->first();

    if ($countPerjalanan < $countEntertain) {
      $jmlBaris = $countEntertain;
    } else {
      $jmlBaris = $countPerjalanan;
    }

    $perBaris = 13;
    $totalPage = ceil($jmlBaris / $perBaris);

    $data = [
      'totalPage' => $totalPage,
      'perBaris' => $perBaris,
      'date' => date('d/m/Y'),
      'dinas' => $dinas,
      'karyawan' => $karyawan
    ];

    $pdf = PDF::loadView('sales.perjalanandinas.print', $data)->setPaper('legal', 'portrait');
    return $pdf->download('perjalanandinas.pdf');
  }

  public function hapus(Request $request)
  {

    $biaya = BiayaPerjalananDinas::where('dinas_id', $request->id)->with(['cashadvance', 'biayaakomodasi'])->first();

    if ($biaya) {
      CashAdvance::where('biaya_perjalanan_dinas_id', $biaya->id)->delete();
      BiayaAkomodasi::where('biaya_perjalanan_dinas_id', $biaya->id)->delete();
      $biaya->delete();
    }
  
    $dinas = Dinas::where('id', $request->id)->with(['perjalanandinas', 'entertaindinas'])->first();

    PerjalananDinas::where('dinas_id', $request->id)->delete();
    EntertainDinas::where('dinas_id', $request->id)->delete();
    $dinas->delete();

    return response()->json('Data Berhasil Dihapus');
  }
}
