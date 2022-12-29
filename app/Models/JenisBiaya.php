<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBiaya extends Model
{
    use HasFactory;

    protected $table = 'jenis_biayas';
    protected $fillable = [
        'nama',
        'no_akun',
        'keterangan'
    ];

  
    public function biayalain()
    {
        return $this->hasMany(BiayaLain::class, 'jenisbiaya_id');
    }
    


}
