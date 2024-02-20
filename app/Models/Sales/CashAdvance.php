<?php

namespace App\Models\Sales;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashAdvance extends Model
{
    use HasFactory,Blameable,SoftDeletes;
    protected $table = 'cash_advance';

    protected $fillable = [
        'biaya_perjalanan_dinas_id',
        'tanggal',
        'nominal'
    ];
   
    public function biayaperjalanandinas()
    {
        return $this->belongsTo(BiayaPerjalananDinas::class, 'biaya_perjalanan_dinas_id', 'id');
    }
    
}
