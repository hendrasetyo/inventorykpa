<?php

namespace App\Models\Sales;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BiayaPerjalananDinas extends Model
{
    use HasFactory,Blameable,SoftDeletes;
    protected $table = 'biaya_perjalanan_dinas';
    protected $fillable = [
        'dinas_id',
        'keterangan'
    ];

    public function cashadvance()
    {
        return $this->hasMany(CashAdvance::class, 'biaya_perjalanan_dinas_id');
    }

    
    public function biayaakomodasi()
    {
        return $this->hasMany(BiayaAkomodasi::class, 'biaya_perjalanan_dinas_id');
    }

   
    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'dinas_id', 'id');
    }

    

    
}
