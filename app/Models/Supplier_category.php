<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier_category extends Model
{
    use HasFactory;
    use Blameable;
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'keterangan'
    ];

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'kategori_id', 'id');
    }
}
