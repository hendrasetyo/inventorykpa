<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StokExpDetail extends Model
{
    use HasFactory;
    use Blameable;
    use SoftDeletes;

    protected $fillable = [
        'tanggal',
        'stok_exp_id',
        'product_id',
        'qty',
        'id_po',
        'id_po_detail',
        'id_pb',
        'id_pb_detail',
        'id_so',
        'id_so_detail',
        'id_sj',
        'id_sj_detail',
        'konversi_id',
        'konversi_detail_id'
    ];

    protected $dates = ['tanggal'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function pengiriman()
    {
        return $this->belongsTo(PengirimanBarang::class, 'id_sj', 'id');
    }

   
    public function stockExp()
    {
        return $this->belongsTo(StokExp::class, 'stok_exp_id', 'id');
    }
}
