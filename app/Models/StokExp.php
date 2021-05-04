<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StokExp extends Model
{
    use HasFactory;
    use Blameable;
    use SoftDeletes;
    protected $fillable = [
        'tanggal',
        'product_id',
        'qty'
    ];

    protected $dates = ['tanggal'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
