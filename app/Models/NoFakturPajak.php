<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoFakturPajak extends Model
{
    use HasFactory,Blameable,SoftDeletes;
    protected $table = 'no_faktur_pajaks';
    protected $fillable = [
        'no_pajak',
        'no_kpa',
        'status',
        'keterangan'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
     
}
