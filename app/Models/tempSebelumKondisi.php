<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tempSebelumKondisi extends Model
{
    use HasFactory;
    protected $table = 'temp_sebelum_kondisi';
    protected $fillable  = [
        'nama_alat',
        'no_seri',
        'keluhan',
        'user_id'   
    ];
}
