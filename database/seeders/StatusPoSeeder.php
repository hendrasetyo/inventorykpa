<?php

namespace Database\Seeders;

use App\Models\StatusPo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusPoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['nama' => 'Draft'],
            ['nama' => 'Posted'],
            ['nama' => 'Process'],
            ['nama' => 'Completed'],
            ['nama' => 'Canceled'],
        ];

        foreach ($data as $a) {

            if (StatusPo::where('nama', $a['nama'])->count() < 1) {
                DB::table('status_pos')->insert([
                    'nama' => $a['nama']

                ]);
            }
        }
    }
}
