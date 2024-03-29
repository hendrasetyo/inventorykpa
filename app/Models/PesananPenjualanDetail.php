<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesananPenjualanDetail extends Model
{
    use HasFactory;
    use Blameable;
    use SoftDeletes;

    protected $fillable = [
        'pesanan_penjualan_id',
        'tanggal',
        'product_id',
        'qty',
        'qty_sisa',
        'satuan',
        'hargajual',
        'diskon_persen',
        'diskon_rp',
        'subtotal',
        'total_diskon',
        'total',
        'ongkir',
        'keterangan',
        'ppn'
    ];

    protected $dates = ['tanggal'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
