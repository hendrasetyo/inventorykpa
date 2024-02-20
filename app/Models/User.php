<?php

namespace App\Models;

use App\Blameable;
use App\Models\HRD\Karyawan;
use App\Models\Sales\Dinas;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, Blameable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'sales_id',
        'phone',
        'karyawan_id'
    ];

   
    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


   
    public function tempbiaya()
    {
        return $this->hasMany(TempBiaya::class, 'id');
    }

    
    public function kunjungan()
    {
        return $this->hasMany(KunjunganSales::class, 'user_id');
    }

   
    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }
    
    public function kunjunganteknisi()
    {
        return $this->hasMany(KunjunganTeknisi::class, 'user_id');
    }

  
    public function dinas()
    {
        return $this->hasMany(Dinas::class, 'user_id');
    }

   
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'user_id', 'id');
    }


   
}
