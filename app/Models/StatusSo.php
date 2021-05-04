<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSo extends Model
{
    use HasFactory;

    public function pesananpenjualan()
    {
        return $this->hasMany(PesananPenjualan::class, 'status_so_id', 'id');
    }
}
