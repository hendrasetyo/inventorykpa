<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merk extends Model
{
    use HasFactory;
    use Blameable;
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'keterangan'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'merk_id', 'id');
    }
}
