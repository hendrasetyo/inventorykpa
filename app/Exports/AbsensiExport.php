<?php

namespace App\Exports;

use App\Models\HRD\Divisi;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AbsensiExport implements FromView
{

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function view(): View
    {

        $tanggal_awal = Carbon::parse($this->data['tanggal_awal'])->format('Y-m-d');
        $tanggal_akhir = Carbon::parse($this->data['tanggal_akhir'])->format('Y-m-d');

        $absensi = DB::table('absensi as ab')
            ->join('karyawan as k', 'ab.karyawan_id', '=', 'k.id')
            ->join('posisi as p', 'k.posisi_id', '=', 'p.id')
            ->join('divisi as d', 'p.divisi_id', '=', 'd.id');

        if ($this->data['tipe_export'] == 'rekap_mingguan') {
            if ($this->data['tanggal_awal']) {
                if (!$this->data['tanggal_akhir']) {
                    $tanggalFilter = $absensi->where('ab.tanggal', '>=', $tanggal_awal);
                } else {
                    $tanggalFilter = $absensi->where('ab.tanggal', '>=', $tanggal_awal)
                        ->where('ab.tanggal', '<=', $tanggal_akhir);
                }
            } elseif ($this->data['tanggal_akhir']) {
                if (!$this->data['tanggal_awal']) {
                    $tanggalFilter = $absensi->where('ab.tanggal', '<=', $tanggal_akhir);
                } else {
                    $tanggalFilter = $absensi->where('ab.tanggal', '>=', $tanggal_awal)
                        ->where('ab.tanggal_top', '<=', $tanggal_akhir);
                }
            } else {
                $tanggalFilter = $absensi;
            }

            $result = $tanggalFilter->select('k.nama as nama_karyawan', 'd.nama as nama_divisi', 'ab.clock_in as clock_in', 'ab.clock_out as clock_out', 'ab.work_time as work_time', 'ab.tanggal as tanggal_absensi', 'ab.status as status')->get();
        } else {
            $filteryear = $absensi->whereYear('ab.tanggal', $this->data['tahun']);
            $filterbulan = $filteryear->whereMonth('ab.tanggal', $this->data['bulan']);
            $result = $filterbulan->select('k.nama as nama_karyawan', 'k.id as id_karyawan', 'd.nama as nama_divisi', 'ab.clock_in as clock_in', 'ab.clock_out as clock_out', 'ab.work_time as work_time', 'ab.tanggal as tanggal_absensi', 'ab.status as status')->get();
            $group = $filterbulan->groupBy('k.nama')->select('k.nama as nama_karyawan', 'k.id as id_karyawan', 'd.nama as nama_divisi', 'ab.clock_in as clock_in', 'ab.clock_out as clock_out', 'ab.work_time as work_time', 'ab.tanggal as tanggal_absensi', 'ab.status as status')->get();

            $lembur = DB::table('lembur as lb')->whereYear('lb.tanggal', $this->data['tahun'])
                ->whereMonth('lb.tanggal', $this->data['bulan'])
                ->select('lb.*')
                ->get();
        }

        $divisi = Divisi::get();




        if ($this->data['tipe_export'] == 'rekap_mingguan') {
            foreach ($divisi as $asset) {
                foreach ($result as $item) {
                    if ($asset->nama == $item->nama_divisi) {


                        $data[$asset->nama][] = [
                            'nama' => $item->nama_karyawan,
                            'id_karyawan' => $item->id_karyawan,
                            'clock_in' => $item->clock_in,
                            'clock_out' => $item->clock_out,
                            'work_time' => $item->work_time,
                            'tanggal' => $item->tanggal_absensi,
                            'status' => $item->status
                        ];
                    }
                }
            }
        } else {
            $ontime = 0;
            $ijin = 0;
            $terlambat = 0;
            $jumlah_jam = 0;
            $tidak_hadir = 0;
            foreach ($group as $item) {
                foreach ($result as $asset) {
                    if ($asset->nama_karyawan == $item->nama_karyawan) {
                        if ($asset->status == 'ontime') {
                            $ontime += 1;
                        } elseif ($asset->status == 'ijin') {
                            $ijin += 1;
                        } elseif ($asset->status == 'terlambat') {
                            $terlambat += 1;
                        }elseif ($asset->status == 'tidak hadir') {
                            $tidak_hadir += 1;
                        }
                    }
                }

                foreach ($lembur as $value) {
                    if ($item->id_karyawan == $value->karyawan_id) {
                        $jumlah_jam += $value->jumlah_jam;
                    }
                }

                $array[] = [
                    'nama' => $item->nama_karyawan,
                    'nama_divisi' => $item->nama_divisi,
                    'ontime' => $ontime,
                    'ijin' => $ijin,
                    'terlambat' => $terlambat,
                    'lembur' => $jumlah_jam,
                    'tidak_hadir' => $tidak_hadir
                ];

                $ontime = 0;
                $ijin = 0;
                $terlambat = 0;
                $jumlah_jam = 0;
                $tidak_hadir = 0;
            }

            foreach ($divisi as $asset) {
                foreach ($array as $item) {
                    if ($asset->nama == $item['nama_divisi']) {
                        $data[$asset->nama][] = [
                            'nama' => $item['nama'],
                            'ontime' => $item['ontime'],
                            'ijin' => $item['ijin'],
                            'terlambat' => $item['terlambat'],
                            'lembur' => $item['lembur'],
                            'tidak_hadir' => $item['tidak_hadir']
                        ];
                    }
                }
            }
        }

        

        if ($this->data['tipe_export'] == 'rekap_mingguan') {
            return view('hrd.absensi.export._export', [
                'data' => $data
            ]);
        }else{
            return view('hrd.absensi.export._exportbulanan', [
                'data' => $data
            ]);
        }
        
      
    }
}
