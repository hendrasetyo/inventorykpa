<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganSales extends Model
{
    use HasFactory;

    protected $table = 'kunjungan_sales';
    protected $fillable = [
        'customer',
        'tanggal',
        'aktifitas',
        'ttd',
        'image',
        'user_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    
}
