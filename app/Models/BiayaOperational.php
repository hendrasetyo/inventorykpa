<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaOperational extends Model
{
    use HasFactory;

    protected $table = 'biaya_operationals';            
    protected $fillable = [
        'tanggal',
        'jenis_biaya_id',
        'nominal',        
        'request',
        'bank_id',
        'keterangan'
    ];


    public function jenisbiaya()
    {
        return $this->belongsTo(JenisBiaya::class, 'jenis_biaya_id', 'id');
    }

  
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }
}
