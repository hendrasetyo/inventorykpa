<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'supplier_id',
        'pesanan_pembelian_id',
        'penerimaan_barang_id',
        'faktur_pembelian_id',
        'dpp',
        'ppn',
        'total',
        'dibayar',
        'status',
        'nominal_toleransi',
        'tanggal_top'
    ];
    protected $dates = ['tanggal'];

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function FakturPO()
    {
        return $this->belongsTo(FakturPembelian::class, 'faktur_pembelian_id', 'id');
    }
    public function PO()
    {
        return $this->belongsTo(PesananPembelian::class, 'pesanan_pembelian_id', 'id');
    }
    public function PB()
    {
        return $this->belongsTo(PenerimaanBarang::class, 'penerimaan_barang_id', 'id');
    }
}
