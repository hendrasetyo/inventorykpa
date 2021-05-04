<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusFaktursos extends Model
{
    use HasFactory;

    public function fakturpenjualan()
    {
        return $this->hasMany(FakturPenjualan::class, 'status_fakturso_id', 'id');
    }
}
