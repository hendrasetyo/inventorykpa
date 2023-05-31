<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetSales extends Model
{
    use HasFactory;

    protected $table = 'target_sales';
    protected $fillable = [
        'sales_id',
        'bulan',
        'tahun',
        'nominal'
    ];
   
    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id', 'id');
    }


}
