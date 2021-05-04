<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPo extends Model
{
    use HasFactory;

    public function pesananpembelian()
    {
        return $this->hasMany(PesananPembelian::class, 'status_po_id', 'id');
    }
}
