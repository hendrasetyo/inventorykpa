<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPerjalananDinas extends Model
{
    use HasFactory;
    protected $table = 'temp_perjalanandinas';
    protected $fillable = [
        'user_id',
        'tujuan',
        'tanggal',
        'asal_mana',
        'waktu_mulai',
        'waktu_selesai',
        'jenis_transportasi',
        'penyedia_transportasi',
        'waktu_berangkat',
        'nama_hotel'
    ];
}
