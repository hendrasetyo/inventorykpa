<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceProduk extends Model
{
    use HasFactory,Blameable,SoftDeletes;

    protected $table = 'maintenance';
    protected $fillable = [
        'nama_lab',
        'pemohon',
        'bagian',
        'telepon',
        'tanggal',
        'alamat',
        'tanggal_dikerjakan',
        'tanggal_selesai_dikerjakan',
        'tempat_pengerjaan',
        'saran' 
    ];
    
    public function sebelumKondisi()
    {
        return $this->hasMany(MaintenanceSebelumKondisi::class, 'maintenance_id');
    }

    public function setelahKondisi()
    {
        return $this->hasMany(MaintenanceSetelahKondisi::class, 'maintenance_id');
    }

    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    
}
