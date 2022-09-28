<?php

namespace App\Imports;

use App\Models\NoFakturPajak;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class NoFakturPajakImport implements ToModel
{
    protected $no=0;
    public function model(array $row)
    {
        if ($this->no !== 0) {
            $nopajak = NoFakturPajak::create([
                'no_pajak' => $row[0],
                'status' => 'Aktif',                
            ]);
        }
        $this->no ++;
        return ;
    }
}
