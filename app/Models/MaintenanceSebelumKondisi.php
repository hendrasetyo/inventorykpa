<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSebelumKondisi extends Model
{
    use HasFactory;
    protected $table = 'maintenance_sebelum_kondisi';
    protected $fillable  = [
        'maintenance_id',
        'nama_alat',
        'no_seri',
        'keluhan'
    ];

    public function maintenance()
    {
        return $this->belongsTo(MaintenanceProduk::class, 'maintenance_produk', 'id');
    }

}
