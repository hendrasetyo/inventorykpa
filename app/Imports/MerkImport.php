<?php

namespace App\Imports;

use App\Models\Merk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class MerkImport implements ToModel
{
    protected $no=0;
    public function model(array $row)
    {
        if ($this->no !== 0) {
            Merk::create([
                'nama' => $row[0],
                'keterangan' => null
            ]);
        }
        $this->no ++;
        return ;
    }
}
