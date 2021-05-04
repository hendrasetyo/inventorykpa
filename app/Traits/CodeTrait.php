<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait CodeTrait
{
    public function hasUppercase($string)
    {
        return preg_match('/[A-Z]/', $string) ? true : false;
    }
    public function hasLowercase($string)
    {
        return preg_match('/[a-z]/', $string) ? true : false;
    }
    public function hasNumber($string)
    {
        return preg_match('#[\d]#', $string) ? true : false;
    }

    public function getKodeData($tabel, $pref)
    {
        $tahun = Carbon::now()->format('y');
        $dats = DB::select("select IFNULL(MAX(SUBSTRING(kode,4,4)),0)*1 as idmax FROM " . $tabel . " where SUBSTRING(kode,2,2) = ?", [$tahun])[0];
        $num = $dats->idmax;
        $num = $num + 1;
        $val = sprintf("%04d", $num);
        $nextId = $pref . $tahun . $val;

        return $nextId;
    }

    public function getKodeTransaksi($tabel, $pref)
    {
        //contoh kode = PO20020001
        $tahun = Carbon::now()->format('y');
        $bulan = Carbon::now()->format('m');
        $dats = DB::select("select IFNULL(MAX(SUBSTRING(kode,7,4)),0)*1 as idmax FROM " . $tabel . " where SUBSTRING(kode,3,2) = ? and SUBSTRING(kode,5,2) = ?", [$tahun, $bulan])[0];
        $num = $dats->idmax;
        $num = $num + 1;
        $val = sprintf("%04d", $num);
        $nextId = $pref . $tahun . $bulan . $val;

        return $nextId;
    }
}
