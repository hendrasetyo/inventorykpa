<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganSales extends Model
{
    use HasFactory; 

    public $timestamps = false;

    protected $table = 'kunjungan_sales';
    protected $fillable = [
        'customer',
        'tanggal',
        'aktifitas',
        'ttd',
        'jam_buat',
        'image',
        'user_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    
}
