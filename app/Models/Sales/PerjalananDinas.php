<?php

namespace App\Models\Sales;

use App\Blameable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerjalananDinas extends Model
{
    use HasFactory,SoftDeletes,Blameable;

    protected $table = 'perjalanan_dinas';
    protected $fillable = [
        'dinas_id',    
        'asal_mana',
        'tujuan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'jenis_transportasi',
        'penyedia_transportasi',
        'waktu_berangkat',
        'nama_hotel'
    ];

   
    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'dinas_id');
    }

    
    public function biayaperjalanandinas()
    {
        return $this->hasMany(BiayaPerjalananDinas::class, 'perjalanandinas_id');
    }


}
