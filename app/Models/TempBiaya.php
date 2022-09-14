<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempBiaya extends Model
{
    use HasFactory;

    protected $table = 'temp_biayas';
    protected $fillable = [
        'jenis',
        'pengiriman_barang_id',
        'rupiah',
        'user_id'
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
  
    public function pengirimanbarang()
    {
        return $this->belongsTo(PengirimanBarang::class, 'pengiriman_barang_id', 'id');
    }
    
    
}
