<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempCanvas extends Model
{
    use HasFactory;

    protected $table = 'temp_canvases';
    protected $fillable = [
        'product_id',
        'qty',
        'qty_sisa',
        'keterangan',
        'user_id'
    ];

  
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    


}
