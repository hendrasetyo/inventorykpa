<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganTeknisi extends Model
{
    use HasFactory;
    protected $table = 'kunjungan_teknisi';
    protected $fillable = [
        'user_id',
        'tanggal',
        'customer',
        'aktifitas',
        'ttd',
        'image',
        'user_id',
    ];

  
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
