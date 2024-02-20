<?php

namespace App\Models\Sales;

use App\Blameable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dinas extends Model
{
    use HasFactory,Blameable,SoftDeletes;

    protected $table = 'dinas';
    protected $fillable = [
        'user_id',
        'tujuan_dinas',  
        'keterangan',
        'status'
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

 
    public function perjalanandinas()
    {
        return $this->hasMany(PerjalananDinas::class, 'dinas_id');
    }

   
    public function entertaindinas()
    {

        return $this->hasMany(EntertainDinas::class, 'dinas_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

   
    public function biayaperjalanandinas()
    {
        return $this->hasMany(Dinas::class, 'dinas_id');
    }
}
