<?php

namespace App\Imports;

use App\Models\HRD\Absensi;
use App\Models\HRD\Karyawan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class AbsensiImport implements ToModel
{
    protected $no=0;
    public function model(array $row)
    {

        $karyawan = Karyawan::where('no_emp',$row[0])->first();

        $timetanggal = strtotime($row[5]);
        // $clockin = strtotime($row[9]);
        // $clockout = strtotime($row[10]);
        // $worktime = strtotime($row[17]);

        if ($row[9] > Carbon::parse('08:15')->format('H:i')) {
            $status = 'terlambat';
        }else{
            $status = 'ontime';
        }
        

        if ($this->no !== 0) {      
            $absensi = Absensi::create([
                'karyawan_id' => $karyawan->id,
                'clock_in' => $row[9],
                'clock_out' => $row[10],
                'work_time' => $row[17],
                'tanggal' => Carbon::parse($timetanggal)->format('Y-m-d'),
                'status' => $status,
                'keterangan' =>  ''       
            ]);
        }
                
        $this->no ++;
        return ;
    }       
}
