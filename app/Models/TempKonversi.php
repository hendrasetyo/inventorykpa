<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempKonversi extends Model
{
    use HasFactory;

    protected $table ='temp_konversis';
    protected $fillable = [
        'tanggal',
        'user_id',
        'product_id',
        'qty',
        'expdate_id',
        'exp_date',
        'status'
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function expdate()
    {
        return $this->belongsTo(StokExp::class, 'expdate_id', 'id');
    }

}
