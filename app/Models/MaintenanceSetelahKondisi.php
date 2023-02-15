<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceSetelahKondisi extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'maintenance_setelah_kondisi';
    protected $fillable = [
        'maintenance_id',
        'nama_sparepart',
        'qty',
        'pekerjaan'        
    ];

    
    public function maintenance()
    {
        return $this->belongsTo(MaintenanceProduk::class, 'maintenance_id', 'id');
    }
    
}
