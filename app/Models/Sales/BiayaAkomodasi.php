<?php

namespace App\Models\Sales;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BiayaAkomodasi extends Model
{
    use HasFactory,Blameable,SoftDeletes;

    protected $table = 'biaya_akomodasi';
    protected $fillable = [
        'perjalanandinas_id',            
        'biaya_perjalanan_dinas_id',
        'biaya_hotel',
        'biaya_transportasi',
        'biaya_makan',
        'biaya_laundry',
        'biaya_entertainment',
        'biaya_lainya',
        'total_biaya'
    ];

    public function biayaperjalanandinas()
    {
        return $this->belongsTo(BiayaPerjalananDinas::class, 'biaya_perjalanan_dinas_id', 'id');
    }

   
    public function perjalanandinas()
    {
        return $this->belongsTo(PerjalananDinas::class, 'perjalanandinas_id', 'id');
    }

}
