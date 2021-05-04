<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembayaranHutang extends Model
{
    use HasFactory;
    use Blameable;
    use SoftDeletes;

    protected $fillable = [
        'tanggal',
        'supplier_id',
        'faktur_pembelian_id',
        'hutang_id',
        'bank_id',
        'nominal',
        'keterangan'
    ];
    protected $dates = ['tanggal'];

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function FakturPO()
    {
        return $this->belongsTo(FakturPembelian::class, 'faktur_pembelian_id', 'id');
    }

    public function banks()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function hutangs()
    {
        return $this->belongsTo(Hutang::class, 'hutang_id', 'id');
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
