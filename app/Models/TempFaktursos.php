<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempFaktursos extends Model
{
    use HasFactory;
    protected $fillable = [

        'pengiriman_barang_id',
        'pengiriman_barang_detail_id',
        'product_id',
        'qty',
        'satuan',
        'hargajual',
        'diskon_persen',
        'diskon_rp',
        'subtotal',
        'total_diskon',
        'total',
        'ongkir',
        'keterangan',
        'user_id',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
