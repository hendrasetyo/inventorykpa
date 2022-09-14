<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CanvassingPesanan extends Model
{
    use HasFactory,Blameable,SoftDeletes;
    protected $table ='canvassing_pesanans';

    protected $fillable=[
        'kode',
        'tanggal',
        'customer_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    
}
