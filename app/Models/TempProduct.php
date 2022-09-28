<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempProduct extends Model
{
    use HasFactory,Blameable;

    protected $table = 'temp_products';
    protected $fillable = [
        'nama',
        'kode',
        'productgroup_id',
        'jenis',
        'merk_id',
        'tipe',
        'ukuran',
        'kemasan',
        'satuan',
        'katalog',
        'asal_negara',
        'pabrikan',
        'no_ijinedar',
        'exp_ijinedar',
        'productcategory_id',
        'productsubcategory_id',
        'hargajual',
        'hargabeli',
        'hpp',
        'diskon_persen',
        'diskon_rp',
        'stok',
        'keterangan',
        'status',
        'status_exp',
        'stok_canvassing',
        'user_id'
    ];
}
