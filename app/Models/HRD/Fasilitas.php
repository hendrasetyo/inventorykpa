<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;
    protected $table = 'fasilitas';
    
    protected $fillable = [
        'jenisfasilitas_id',
        'nama',
        'nominal'
    ];
    
    public function tipefasilitas()
    {
        return $this->belongsTo(TipeFasilitas::class, 'jenisfasilitas_id', 'id');
    }

}
