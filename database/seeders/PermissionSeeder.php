<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ['name' => 'customer-list', 'guard_name' => 'web'],
            ['name' => 'customer-create', 'guard_name' => 'web'],
            ['name' => 'customer-edit', 'guard_name' => 'web'],
            ['name' => 'customer-delete', 'guard_name' => 'web'],
            ['name' => 'supplier-list', 'guard_name' => 'web'],
            ['name' => 'supplier-create', 'guard_name' => 'web'],
            ['name' => 'supplier-edit', 'guard_name' => 'web'],
            ['name' => 'supplier-delete', 'guard_name' => 'web'],
            ['name' => 'product-list', 'guard_name' => 'web'],
            ['name' => 'product-create', 'guard_name' => 'web'],
            ['name' => 'product-edit', 'guard_name' => 'web'],
            ['name' => 'product-delete', 'guard_name' => 'web'],
            ['name' => 'user-list', 'guard_name' => 'web'],
            ['name' => 'user-create', 'guard_name' => 'web'],
            ['name' => 'user-edit', 'guard_name' => 'web'],
            ['name' => 'user-delete', 'guard_name' => 'web'],
            ['name' => 'navigation-list', 'guard_name' => 'web'],
            ['name' => 'navigation-create', 'guard_name' => 'web'],
            ['name' => 'navigation-edit', 'guard_name' => 'web'],
            ['name' => 'navigation-delete', 'guard_name' => 'web'],
            ['name' => 'role-list', 'guard_name' => 'web'],
            ['name' => 'role-create', 'guard_name' => 'web'],
            ['name' => 'role-edit', 'guard_name' => 'web'],
            ['name' => 'role-delete', 'guard_name' => 'web'],
            ['name' => 'permission-list', 'guard_name' => 'web'],
            ['name' => 'permission-create', 'guard_name' => 'web'],
            ['name' => 'permission-edit', 'guard_name' => 'web'],
            ['name' => 'permission-delete', 'guard_name' => 'web'],
            ['name' => 'salesorder-list', 'guard_name' => 'web'],
            ['name' => 'salesorder-create', 'guard_name' => 'web'],
            ['name' => 'salesorder-edit', 'guard_name' => 'web'],
            ['name' => 'salesorder-delete', 'guard_name' => 'web'],
            ['name' => 'assign-list', 'guard_name' => 'web'],
            ['name' => 'assign-create', 'guard_name' => 'web'],
            ['name' => 'assign-edit', 'guard_name' => 'web'],
            ['name' => 'assign-delete', 'guard_name' => 'web'],
            ['name' => 'sales-list', 'guard_name' => 'web'],
            ['name' => 'sales-create', 'guard_name' => 'web'],
            ['name' => 'sales-edit', 'guard_name' => 'web'],
            ['name' => 'sales-delete', 'guard_name' => 'web'],
            ['name' => 'customercategory-list', 'guard_name' => 'web'],
            ['name' => 'customercategory-create', 'guard_name' => 'web'],
            ['name' => 'customercategory-edit', 'guard_name' => 'web'],
            ['name' => 'customercategory-delete', 'guard_name' => 'web'],
            ['name' => 'suppliercategory-list', 'guard_name' => 'web'],
            ['name' => 'suppliercategory-create', 'guard_name' => 'web'],
            ['name' => 'suppliercategory-edit', 'guard_name' => 'web'],
            ['name' => 'suppliercategory-delete', 'guard_name' => 'web'],
            ['name' => 'productcategory-list', 'guard_name' => 'web'],
            ['name' => 'productcategory-create', 'guard_name' => 'web'],
            ['name' => 'productcategory-edit', 'guard_name' => 'web'],
            ['name' => 'productcategory-delete', 'guard_name' => 'web'],
            ['name' => 'producsubcategory-list', 'guard_name' => 'web'],
            ['name' => 'producsubcategory-create', 'guard_name' => 'web'],
            ['name' => 'producsubcategory-edit', 'guard_name' => 'web'],
            ['name' => 'producsubcategory-delete', 'guard_name' => 'web'],
            ['name' => 'satuan-list', 'guard_name' => 'web'],
            ['name' => 'satuan-create', 'guard_name' => 'web'],
            ['name' => 'satuan-edit', 'guard_name' => 'web'],
            ['name' => 'satuan-delete', 'guard_name' => 'web'],
            ['name' => 'merk-list', 'guard_name' => 'web'],
            ['name' => 'merk-create', 'guard_name' => 'web'],
            ['name' => 'merk-edit', 'guard_name' => 'web'],
            ['name' => 'merk-delete', 'guard_name' => 'web'],
            ['name' => 'productgroup-list', 'guard_name' => 'web'],
            ['name' => 'productgroup-create', 'guard_name' => 'web'],
            ['name' => 'productgroup-edit', 'guard_name' => 'web'],
            ['name' => 'productgroup-delete', 'guard_name' => 'web'],
            ['name' => 'kategoripesanan-list', 'guard_name' => 'web'],
            ['name' => 'kategoripesanan-create', 'guard_name' => 'web'],
            ['name' => 'kategoripesanan-edit', 'guard_name' => 'web'],
            ['name' => 'kategoripesanan-delete', 'guard_name' => 'web'],
            ['name' => 'komoditas-list', 'guard_name' => 'web'],
            ['name' => 'komoditas-create', 'guard_name' => 'web'],
            ['name' => 'komoditas-edit', 'guard_name' => 'web'],
            ['name' => 'komoditas-delete', 'guard_name' => 'web'],
            ['name' => 'company-list', 'guard_name' => 'web'],
            ['name' => 'company-create', 'guard_name' => 'web'],
            ['name' => 'company-edit', 'guard_name' => 'web'],
            ['name' => 'company-delete', 'guard_name' => 'web'],
            ['name' => 'pesananpembelian-list', 'guard_name' => 'web'],
            ['name' => 'pesananpembelian-create', 'guard_name' => 'web'],
            ['name' => 'pesananpembelian-edit', 'guard_name' => 'web'],
            ['name' => 'pesananpembelian-delete', 'guard_name' => 'web'],
            ['name' => 'penerimaanbarang-list', 'guard_name' => 'web'],
            ['name' => 'penerimaanbarang-create', 'guard_name' => 'web'],
            ['name' => 'penerimaanbarang-edit', 'guard_name' => 'web'],
            ['name' => 'penerimaanbarang-delete', 'guard_name' => 'web'],
            ['name' => 'fakturpembelian-list', 'guard_name' => 'web'],
            ['name' => 'fakturpembelian-create', 'guard_name' => 'web'],
            ['name' => 'fakturpembelian-edit', 'guard_name' => 'web'],
            ['name' => 'fakturpembelian-delete', 'guard_name' => 'web'],
            ['name' => 'pesananpenjualan-list', 'guard_name' => 'web'],
            ['name' => 'pesananpenjualan-create', 'guard_name' => 'web'],
            ['name' => 'pesananpenjualan-edit', 'guard_name' => 'web'],
            ['name' => 'pesananpenjualan-delete', 'guard_name' => 'web'],
            ['name' => 'pengirimanbarang-list', 'guard_name' => 'web'],
            ['name' => 'pengirimanbarang-create', 'guard_name' => 'web'],
            ['name' => 'pengirimanbarang-edit', 'guard_name' => 'web'],
            ['name' => 'pengirimanbarang-delete', 'guard_name' => 'web'],
            ['name' => 'fakturpenjualan-list', 'guard_name' => 'web'],
            ['name' => 'fakturpenjualan-create', 'guard_name' => 'web'],
            ['name' => 'fakturpenjualan-edit', 'guard_name' => 'web'],
            ['name' => 'fakturpenjualan-delete', 'guard_name' => 'web'],
            ['name' => 'pembayaranhutang-list', 'guard_name' => 'web'],
            ['name' => 'pembayaranhutang-create', 'guard_name' => 'web'],
            ['name' => 'pembayaranhutang-edit', 'guard_name' => 'web'],
            ['name' => 'pembayaranhutang-delete', 'guard_name' => 'web'],
            ['name' => 'pembayaranpiutang-list', 'guard_name' => 'web'],
            ['name' => 'pembayaranpiutang-create', 'guard_name' => 'web'],
            ['name' => 'pembayaranpiutang-edit', 'guard_name' => 'web'],
            ['name' => 'pembayaranpiutang-delete', 'guard_name' => 'web'],
            ['name' => 'pembayaran-list', 'guard_name' => 'web'],
            ['name' => 'pembayaran-create', 'guard_name' => 'web'],
            ['name' => 'pembayaran-edit', 'guard_name' => 'web'],
            ['name' => 'pembayaran-delete', 'guard_name' => 'web'],
        ];

        foreach ($data as $a) {

            if (Permission::where('name', $a['name'])->count() < 1) {
                DB::table('permissions')->insert([
                    'name' => $a['name'],
                    'guard_name' => $a['guard_name'],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }
        }
    }
}
