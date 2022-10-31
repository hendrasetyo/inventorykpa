<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoKPA extends Model
{
    use HasFactory;
    protected $table = 'no_kpa';

    protected $fillable = [
        'no_kpa',
        'status'
    ];


    
}
