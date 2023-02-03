<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSetelahKondisi extends Model
{
    use HasFactory;

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
