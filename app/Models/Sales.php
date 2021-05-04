<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sales extends Model
{
    use Blameable;
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'hp',
        'nip',
        'keterangan'
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
