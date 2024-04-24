<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembuat extends Model
{
    use HasFactory;

    protected $table = 'pembuat';
    protected $fillable = [
        'nama',
        'inisial'
    ];
}
