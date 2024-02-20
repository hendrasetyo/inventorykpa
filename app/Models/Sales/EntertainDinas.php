<?php

namespace App\Models\Sales;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntertainDinas extends Model
{
    use HasFactory,Blameable,SoftDeletes;

    protected $table = 'entertain_dinas';
    protected $fillable = [
        'dinas_id',
        'nama_perusahaan',
        'nama',
        'jenis_entertainment',
        'tujuan_entertainment',
    ];

  
    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'dinas_id', 'id');
    }
}