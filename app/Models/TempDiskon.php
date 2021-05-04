<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempDiskon extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'persen',
        'rupiah',
        'user_id',
    ];
}
