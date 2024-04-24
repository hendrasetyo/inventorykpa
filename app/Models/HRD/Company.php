<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'company';
    protected $fillable = [
        'nama',
        'inisial'
    ];
    
}
