<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPb extends Model
{
    use HasFactory;

    public function penerimaanbarang()
    {
        return $this->hasMany(PenerimaanBarang::class, 'status_pb_id', 'id');
    }
}
