<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tempSetelahKondisi extends Model
{
    use HasFactory;
    protected $table = 'temp_setelah_kondisi';
    protected $fillable = [
        'nama_sparepart',
        'qty',
        'pekerjaan',
        'user_id'   
    ];

    
}
