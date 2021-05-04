<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusFakturpos extends Model
{
    use HasFactory;

    public function fakturpembelian()
    {
        return $this->hasMany(FakturPembelian::class, 'status_fakturpo_id', 'id');
    }
}
