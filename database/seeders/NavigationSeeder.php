<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Navigation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['parent_id' => '1', 'name' => 'is-parent', 'url' => '', 'permission_name' => '', 'icon' => '', 'urut' => '0'],

        ];

        foreach ($data as $a) {

            if (Navigation::where('name', $a['name'])->count() < 1) {
                DB::table('navigations')->insert([
                    'parent_id' => $a['parent_id'],
                    'name' => $a['name'],
                    'url' => $a['url'],
                    'permission_name' => $a['permission_name'],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'icon' => $a['icon'],
                    'urut' => $a['urut'],
                ]);
            }
        }
    }
}
