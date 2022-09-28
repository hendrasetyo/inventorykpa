<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Konversi extends Model
{
    use HasFactory;
    use Blameable;
    use SoftDeletes;

    protected $table ='konversis';
    protected $fillable = [
        'tanggal',
        'kode',
        'user_id',
        'product_id',
        'qty',
        'expdate_id',
        'exp_date',
        'keterangan'
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

}
