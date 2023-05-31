<?php

namespace App\Imports;

use App\Models\TargetSales;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class TargetSalesImport implements ToModel
{
    protected $no=0;
    public function model(array $row)
    {
        if ($this->no !== 0) {
            TargetSales::create([
                'sales_id' => $row[2],
                'bulan' => $row[1],
                'tahun' => $row[0],
                'nominal' => $row[3]
            ]);
            
        }
        $this->no ++;
        
        return ;
    }
}
