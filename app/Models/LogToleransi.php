<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogToleransi extends Model
{
    use HasFactory;
    protected $table = 'log_toleransis';

    protected $fillable = [
        'tanggal',
        'rupiah',
        'jenis',
        'jenis_id',        
    ];

   
    public function hutang()
    {
        return $this->belongsTo(Hutang::class, 'hutang_id', 'id');
    }

    public function piutang()
    {
        return $this->belongsTo(Piutang::class, 'piutang_id', 'id');
    }

    


}
