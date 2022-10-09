<?php

namespace App\Models;

use App\Blameable;
use App\Models\Sales;
use App\Models\Customer_category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class Customer extends Model
{
    use HasFactory;
    use Blameable;
    use SoftDeletes;

    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'blok',
        'nomor',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kodepos',
        'tlp',
        'email',
        'npwp',
        'sales_id',
        'kategori_id',
        'keterangan'
    ];

    public function kategori()
    {
        return $this->belongsTo(Customer_category::class, 'kategori_id', 'id');
    }

    public function kelurahans()
    {
        return $this->belongsTo(Village::class, 'kelurahan', 'id');
    }

    public function kecamatans()
    {
        return $this->belongsTo(District::class, 'kecamatan', 'id');
    }

    public function namakota()
    {
        return $this->belongsTo(City::class, 'kota', 'id');
    }


    public function prov()
    {
        return $this->belongsTo(Province::class, 'provinsi', 'id');
    }

    public function salesman()
    {
        return $this->belongsTo(Sales::class, 'sales_id', 'id');
    }


    
    public function piutang()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
