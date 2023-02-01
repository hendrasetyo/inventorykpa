<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembayaranPiutang extends Model
{
    use HasFactory;
    use Blameable;
    use SoftDeletes;

    protected $fillable = [
        'tanggal',
        'customer_id',
        'faktur_penjualan_id',
        'piutang_id',
        'bank_id',
        'nominal',
        'keterangan'
    ];
    protected $dates = ['tanggal'];


    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function fakturpenjualan()
    {
        return $this->belongsTo(FakturPenjualan::class, 'faktur_penjualan_id', 'id');
    }

    public function banks()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function piutangs()
    {
        return $this->belongsTo(Piutang::class, 'piutang_id', 'id');
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
