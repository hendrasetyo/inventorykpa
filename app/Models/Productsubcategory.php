<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productsubcategory extends Model
{
    use HasFactory;

    use Blameable;
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'productcategory_id'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'productsubcategory_id', 'id');
    }

    public function categories()
    {
        return $this->belongsTo(Productcategory::class, 'productcategory_id', 'id');
    }
}
