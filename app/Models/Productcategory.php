<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productcategory extends Model
{
    use HasFactory;
    use Blameable;
    use SoftDeletes;

    protected $fillable = [
        'nama',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'productcategory_id', 'id');
    }

    public function subcategories()
    {
        return $this->hasMany(Productsubcategory::class, 'productsubcategory_id', 'id');
    }
}
