<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'alamat',
        'npwp',
        'tlp',
        'email',
        'npwp',
        'fax',
        'email',
        'website',
        'latitude',
        'longitude',
        'logo',
    ];
}
