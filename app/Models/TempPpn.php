<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPpn extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'persen',
        'user_id',
    ];
}
