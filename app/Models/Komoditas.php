<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Komoditas extends Model
{
    use HasFactory;
    use Blameable;
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'keterangan'
    ];

    public function pesananpembelian()
    {
        return $this->hasMany(PesananPembelian::class, 'komoditas_id', 'id');
    }
}
