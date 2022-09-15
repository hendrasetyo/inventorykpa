<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'customer_id',
        'pesanan_penjualan_id',
        'pengiriman_barang_id',
        'faktur_penjualan_id',
        'dpp',
        'ppn',
        'total',
        'dibayar',
        'status',
        'nominal_toleransi',
        'tanggal_top'
    ];
    protected $dates = ['tanggal'];

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function FakturSO()
    {
        return $this->belongsTo(FakturPenjualan::class, 'faktur_penjualan_id', 'id');
    }
    public function SO()
    {
        return $this->belongsTo(PesananPenjualan::class, 'pesanan_penjualan_id', 'id');
    }
    public function SJ()
    {
        return $this->belongsTo(PengirimanBarang::class, 'pengiriman_barang_id', 'id');
    }
}
