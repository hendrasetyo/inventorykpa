<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempEntertainDinas extends Model
{
    use HasFactory;
    protected $table = 'temp_entertaindinas';
    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'nama',
        'jenis_entertainment',
        'tujuan_entertainment'        
    ];
}
