<?php

namespace App\Exports;

use App\Models\Supplier;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportSupplier implements FromView
{
    
    public function view(): View
    {
        $supplier = Supplier::with('kategori','kelurahans','kecamatans','namakota','prov')->whereNotIn('nama',[
        'PT. ABADINUSA USAHASEMESTA',
        'PT. BOLD TECHNOLOGIES LEADING INDONESIA',
        'PT. CIPTA ARKA NIAGA',
        'PT. ENSEVAL MEDIKA PRIMA',
        'PT. PANASONIC GOBEL LIFE SOLUTIONS MANUFACTURING INDONESIA',
        'PT. ANUGERAH SANTOSA ABADI',
        'PT. ANUGRAH PERSADA SEMESTA',
        'PT. AGARINDO BIOLOGICAL LABORATORY',
        'PT. ANUGRAH ARGON MEDICA',
        'PT. AKURAT INTAN MADYA',
        'PT. BIMA SATYA NUSANTARA',
        'PT. DIAGNOSTIKA SISTIM INDONESIA',
        'PT. DIASTIKA BIOTEKINDO',
        'PT. ENDO INDONESIA',
        'PT. ENSEVAL PUTERA MEGATRADING',
        'PT. FARIZTA JAYA AGUNG',
        'PT. GLOBAL PHARMA INDONESIA',
        'PT. HEKSA MANUNGGAL',
        'PT. INTISUMBER HASIL SEMPURNA',
        'PT. INDOFA UTAMA MULTICORE',
        'PT. KEBAYORAN PHARMA',
        'PT. MRK DIAGNOSTICS',
        'PT. MRK DIAGNOSTICS',
        'CV. MITRA MEGAH MANDIRI',
        'PT. MULTY SYNERGY PERSADA',
        'PT. MUTUAL BAHTERA SANTOSO',
        'PT. MERAPI UTAMA PHARMA (Sidoarjo)',
        'PT. MERAPI UTAMA PHARMA (Sidoarjo II)',
        'PT MERAPI UTAMA PHARMA (MALANG)',
        'PT MERAPI UTAMA PHARMA (MALANG)',
        'MERAPI UTAMA PHARMA',
        'PT. MEDIAN UNITAMA',
        'PT. NELTA MULTI GRACIA',
        'PT. PIONER INDO NUSANTARA',
        'PT. RAJAERBA INDOCHEM',
        'PT. SABA INDOMEDIKA',
        'PT. SAMUDRA CITRA PERSADA',
        'PT. TAWADA HEALTHCARE',
        'PT. TRANSMEDIC INDONESIA',
        'PT. ZOE PELITA NUSANTARA',])->get();
        
        return view('laporan.master.supplier',compact('supplier'));
    }
}