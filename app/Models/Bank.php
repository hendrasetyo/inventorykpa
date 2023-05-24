<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'banks';
    protected $fillable = [
        'nama',
        'nomor'
    ];

    
    public function biayaoperational()
    {
        return $this->hasMany(Bank::class, 'bank_id');
    }
}
