<?php

use App\Http\Controllers\AdjustmentStok\AdjustmentStokController;
use App\Http\Controllers\BiayaOperational\BiayaOperationalController;
use App\Http\Controllers\Canvassing\CanvassingPengembalianController;
use App\Http\Controllers\Canvassing\CanvassingPesananController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Role;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Konversi\KonversiController;
use App\Http\Controllers\KunjunganSales\KunjunganSalesController;
use App\Http\Controllers\Laporan\LaporanAdjustmentStokController;
use App\Http\Controllers\Laporan\LaporanBiayaOperationalController;
use App\Http\Controllers\Laporan\LaporanFakturPajakController;
use App\Http\Controllers\Laporan\LaporanHutangPiutangController;
use App\Http\Controllers\Laporan\LaporanLabaRugiController;
use App\Http\Controllers\Laporan\LaporanPenjualanController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\Master\MerkController;
use App\Http\Controllers\Master\SalesController;
use App\Http\Controllers\Master\SatuanController;
use App\Http\Controllers\Master\CompanyController;
use App\Http\Controllers\Master\ProductController;
use App\Http\Controllers\Master\CustomerController;
use App\Http\Controllers\Master\SupplierController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Master\KomoditasController;
use App\Http\Controllers\Permissions\RoleController;
use App\Http\Controllers\Permissions\UserController;
use App\Http\Controllers\Profile\ProfilePicController;
use App\Http\Controllers\Laporan\LaporanStokController;
use App\Http\Controllers\Laporan\LaporanPembayaranController;
use App\Http\Controllers\Laporan\LaporanPembelianController;
use App\Http\Controllers\Laporan\LaporanSalesController;
use App\Http\Controllers\Master\ProductGroupController;
use App\Http\Controllers\Master\KategoriPesananController;
use App\Http\Controllers\Master\ProductCategoryController;
use App\Http\Controllers\Permissions\PermissionController;
use App\Http\Controllers\Profile\UpdatePasswordController;
use App\Http\Controllers\Master\CustomerCategoryController;
use App\Http\Controllers\Master\JenisBiayaController;
use App\Http\Controllers\Master\NoFakturPajakController;
use App\Http\Controllers\Master\SupplierCategoryController;
use App\Http\Controllers\Master\ProductSubCategoryController;
use App\Http\Controllers\Pembelian\FakturPembelianController;
use App\Http\Controllers\Penjualan\FakturPenjualanController;
use App\Http\Controllers\Pembelian\PenerimaanBarangController;
use App\Http\Controllers\Pembelian\PesananPembelianController;
use App\Http\Controllers\Penjualan\PengirimanBarangController;
use App\Http\Controllers\Penjualan\PesananPenjualanController;
use App\Http\Controllers\Pembayaran\PembayaranHutangController;
use App\Http\Controllers\Pembayaran\PembayaranPiutangController;
use App\Http\Controllers\Penjualan\BiayaLainController;
use App\Http\Controllers\Penjualan\LabaRugiController;
use App\Http\Controllers\Permissions\AssignPermissionController;
use App\Http\Controllers\Teknisi\MaintenanceController;


Route::middleware('auth', 'verified')->group(function () {
    // Route::get('/', function () {
    //     return view('home');
    // });
    Route::get('/', [HomeController::class, 'index']);
    Route::post('/chartyear', [HomeController::class, 'chartyear'])->name('chart.year');

    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/edit', [ProfileController::class, 'updateProfileInformation']);

    Route::get('password/edit', [UpdatePasswordController::class, 'edit'])->name('password.edit');
    Route::put('password/edit', [UpdatePasswordController::class, 'updatePassword']);

    Route::get('profilepic/edit', [ProfilePicController::class, 'edit'])->name('profilepic.edit');
    Route::put('profilepic/edit', [ProfilePicController::class, 'updateProfilePic']);
});

Route::middleware('has.role')->prefix('master')->group(function () {

    Route::prefix('role-and-permission')->group(function () {
        Route::prefix('roles')->group(function () {
            Route::get('', [RoleController::class, 'index'])->name('roles.index');
            Route::post('create', [RoleController::class, 'store'])->name('roles.create');
            Route::get('{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
            Route::put('{role}/edit', [RoleController::class, 'update'])->name('roles.update');
        });

        Route::prefix('permissions')->group(function () {
            Route::get('', [PermissionController::class, 'index'])->name('permissions.index');
            Route::post('create', [PermissionController::class, 'store'])->name('permissions.create');
            Route::get('{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
            Route::put('{permission}/edit', [PermissionController::class, 'update'])->name('permissions.update');
        });

        Route::prefix('assignpermissions')->group(function () {
            Route::get('', [AssignPermissionController::class, 'index'])->name('assignpermission.index');
            Route::post('create', [AssignPermissionController::class, 'store'])->name('assignpermission.create');
            Route::get('{role}/edit', [AssignPermissionController::class, 'edit'])->name('assignpermission.edit');
            Route::put('{role}/edit', [AssignPermissionController::class, 'sync'])->name('assignpermission.sync');
        });

        Route::prefix('users')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('user.index');
            Route::get('create', [UserController::class, 'create'])->name('user.create');
            Route::post('create', [UserController::class, 'store']);
            Route::get('{user}/edit', [UserController::class, 'edit'])->name('user.edit');
            Route::put('{user}/edit', [UserController::class, 'update'])->name('user.update');
            Route::post('delete', [UserController::class, 'delete'])->name('user.delete');
            Route::delete('delete', [UserController::class, 'destroy'])->name('user.destroy');
        });

       
    });

    Route::prefix('navigations')->group(function () {
        Route::get('', [NavigationController::class, 'index'])->name('navigation.index');
        Route::get('create', [NavigationController::class, 'create'])->name('navigation.create');
        Route::post('create', [NavigationController::class, 'store']);
        Route::get('{navigation}/edit', [NavigationController::class, 'edit'])->name('navigation.edit');
        Route::put('{navigation}/edit', [NavigationController::class, 'update'])->name('navigation.update');
        Route::post('delete', [NavigationController::class, 'delete'])->name('navigation.delete');
        Route::delete('delete', [NavigationController::class, 'destroy'])->name('navigation.destroy');
    });

    Route::prefix('sales')->group(function () {
        Route::get('', [SalesController::class, 'index'])->name('sales.index');
        Route::get('create', [SalesController::class, 'create'])->name('sales.create');
        Route::post('create', [SalesController::class, 'store']);
        Route::get('{sales}/edit', [SalesController::class, 'edit'])->name('sales.edit');
        Route::put('{sales}/edit', [SalesController::class, 'update'])->name('sales.update');
        Route::post('delete', [SalesController::class, 'delete'])->name('sales.delete');
        Route::delete('delete', [SalesController::class, 'destroy'])->name('sales.destroy');
    });
    Route::prefix('customer')->group(function () {
        Route::get('', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('create', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('create', [CustomerController::class, 'store']);
        Route::get('{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::put('{customer}/edit', [CustomerController::class, 'update'])->name('customer.update');
        Route::post('delete', [CustomerController::class, 'delete'])->name('customer.delete');
        Route::delete('delete', [CustomerController::class, 'destroy'])->name('customer.destroy');
        Route::post('detail', [CustomerController::class, 'detail'])->name('customer.detail');

        Route::post('getkota', [CustomerController::class, 'getkota'])->name('customer.getkota');
        Route::post('getkecamatan', [CustomerController::class, 'getkecamatan'])->name('customer.getkecamatan');
        Route::post('getkelurahan', [CustomerController::class, 'getkelurahan'])->name('customer.getkelurahan');
    });
    Route::prefix('customercategory')->group(function () {
        Route::get('', [CustomerCategoryController::class, 'index'])->name('customercategory.index');
        Route::get('create', [CustomerCategoryController::class, 'create'])->name('customercategory.create');
        Route::post('create', [CustomerCategoryController::class, 'store']);
        Route::get('{customercategory}/edit', [CustomerCategoryController::class, 'edit'])->name('customercategory.edit');
        Route::put('{customercategory}/edit', [CustomerCategoryController::class, 'update'])->name('customercategory.update');
        Route::post('delete', [CustomerCategoryController::class, 'delete'])->name('customercategory.delete');
        Route::delete('delete', [CustomerCategoryController::class, 'destroy'])->name('customercategory.destroy');
    });

    Route::prefix('supplier')->group(function () {
        Route::get('', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('create', [SupplierController::class, 'store']);
        Route::get('{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('{supplier}/edit', [SupplierController::class, 'update'])->name('supplier.update');
        Route::post('delete', [SupplierController::class, 'delete'])->name('supplier.delete');
        Route::delete('delete', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        Route::post('detail', [SupplierController::class, 'detail'])->name('supplier.detail');

        Route::post('getkota', [SupplierController::class, 'getkota'])->name('supplier.getkota');
        Route::post('getkecamatan', [SupplierController::class, 'getkecamatan'])->name('supplier.getkecamatan');
        Route::post('getkelurahan', [SupplierController::class, 'getkelurahan'])->name('supplier.getkelurahan');
    });
    Route::prefix('suppliercategory')->group(function () {
        Route::get('', [SupplierCategoryController::class, 'index'])->name('suppliercategory.index');
        Route::get('create', [SupplierCategoryController::class, 'create'])->name('suppliercategory.create');
        Route::post('create', [SupplierCategoryController::class, 'store']);
        Route::get('{suppliercategory}/edit', [SupplierCategoryController::class, 'edit'])->name('suppliercategory.edit');
        Route::put('{suppliercategory}/edit', [SupplierCategoryController::class, 'update'])->name('suppliercategory.update');
        Route::post('delete', [SupplierCategoryController::class, 'delete'])->name('suppliercategory.delete');
        Route::delete('delete', [SupplierCategoryController::class, 'destroy'])->name('suppliercategory.destroy');
    });

    Route::prefix('produk')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('product.index');
        Route::get('create', [ProductController::class, 'create'])->name('product.create');
        Route::post('create', [ProductController::class, 'store']);
        Route::get('{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('{product}/edit', [ProductController::class, 'update'])->name('product.update');
        Route::post('delete', [ProductController::class, 'delete'])->name('product.delete');
        Route::delete('delete', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::post('detail', [ProductController::class, 'show'])->name('product.detail');
        Route::post('getproductsubcategory', [ProductController::class, 'getproductsubcategory'])->name('product.getproductsubcategory');

        Route::post('import', [ProductController::class, 'import'])->name('product.import');

        Route::post('export', [ProductController::class, 'export'])->name('product.export');
        
        Route::get('syncronisasi', [ProductController::class, 'syncronisasi'])->name('product.syncronisasi');



    });

    Route::prefix('produkgroup')->group(function () {
        Route::get('', [ProductGroupController::class, 'index'])->name('productgroup.index');
        Route::get('create', [ProductGroupController::class, 'create'])->name('productgroup.create');
        Route::post('create', [ProductGroupController::class, 'store']);
        Route::get('{productgroup}/edit', [ProductGroupController::class, 'edit'])->name('productgroup.edit');
        Route::put('{productgroup}/edit', [ProductGroupController::class, 'update'])->name('productgroup.update');
        Route::post('delete', [ProductGroupController::class, 'delete'])->name('productgroup.delete');
        Route::delete('delete', [ProductGroupController::class, 'destroy'])->name('productgroup.destroy');
    });

    Route::prefix('satuan')->group(function () {
        Route::get('', [SatuanController::class, 'index'])->name('satuan.index');
        Route::get('create', [SatuanController::class, 'create'])->name('satuan.create');
        Route::post('create', [SatuanController::class, 'store']);
        Route::get('{satuan}/edit', [SatuanController::class, 'edit'])->name('satuan.edit');
        Route::put('{satuan}/edit', [SatuanController::class, 'update'])->name('satuan.update');
        Route::post('delete', [SatuanController::class, 'delete'])->name('satuan.delete');
        Route::delete('delete', [SatuanController::class, 'destroy'])->name('satuan.destroy');
    });

    Route::prefix('merk')->group(function () {
        Route::get('', [MerkController::class, 'index'])->name('merk.index');
        Route::get('create', [MerkController::class, 'create'])->name('merk.create');
        Route::post('create', [MerkController::class, 'store']);
        Route::get('{merk}/edit', [MerkController::class, 'edit'])->name('merk.edit');
        Route::put('{merk}/edit', [MerkController::class, 'update'])->name('merk.update');
        Route::post('delete', [MerkController::class, 'delete'])->name('merk.delete');
        Route::delete('delete', [MerkController::class, 'destroy'])->name('merk.destroy');

        Route::post('import', [MerkController::class, 'import'])->name('merk.import');


    });

    Route::prefix('productcategory')->group(function () {
        Route::get('', [ProductCategoryController::class, 'index'])->name('productcategory.index');
        Route::get('create', [ProductCategoryController::class, 'create'])->name('productcategory.create');
        Route::post('create', [ProductCategoryController::class, 'store']);
        Route::get('{productcategory}/edit', [ProductCategoryController::class, 'edit'])->name('productcategory.edit');
        Route::put('{productcategory}/edit', [ProductCategoryController::class, 'update'])->name('productcategory.update');
        Route::post('delete', [ProductCategoryController::class, 'delete'])->name('productcategory.delete');
        Route::delete('delete', [ProductCategoryController::class, 'destroy'])->name('productcategory.destroy');
    });

    Route::prefix('productsubcategory')->group(function () {
        Route::get('', [ProductSubCategoryController::class, 'index'])->name('productsubcategory.index');
        Route::get('create', [ProductSubCategoryController::class, 'create'])->name('productsubcategory.create');
        Route::post('create', [ProductSubCategoryController::class, 'store']);
        Route::get('{productsubcategory}/edit', [ProductSubCategoryController::class, 'edit'])->name('productsubcategory.edit');
        Route::put('{productsubcategory}/edit', [ProductSubCategoryController::class, 'update'])->name('productsubcategory.update');
        Route::post('delete', [ProductSubCategoryController::class, 'delete'])->name('productsubcategory.delete');
        Route::delete('delete', [ProductSubCategoryController::class, 'destroy'])->name('productsubcategory.destroy');
    });

    Route::prefix('kategoripesanan')->group(function () {
        Route::get('', [KategoriPesananController::class, 'index'])->name('kategoripesanan.index');
        Route::get('create', [KategoriPesananController::class, 'create'])->name('kategoripesanan.create');
        Route::post('create', [KategoriPesananController::class, 'store']);
        Route::get('{kategoripesanan}/edit', [KategoriPesananController::class, 'edit'])->name('kategoripesanan.edit');
        Route::put('{kategoripesanan}/edit', [KategoriPesananController::class, 'update'])->name('kategoripesanan.update');
        Route::post('delete', [KategoriPesananController::class, 'delete'])->name('kategoripesanan.delete');
        Route::delete('delete', [KategoriPesananController::class, 'destroy'])->name('kategoripesanan.destroy');
    });

    Route::prefix('komoditas')->group(function () {
        Route::get('', [KomoditasController::class, 'index'])->name('komoditas.index');
        Route::get('create', [KomoditasController::class, 'create'])->name('komoditas.create');
        Route::post('create', [KomoditasController::class, 'store']);
        Route::get('{komoditas}/edit', [KomoditasController::class, 'edit'])->name('komoditas.edit');
        Route::put('{komoditas}/edit', [KomoditasController::class, 'update'])->name('komoditas.update');
        Route::post('delete', [KomoditasController::class, 'delete'])->name('komoditas.delete');
        Route::delete('delete', [KomoditasController::class, 'destroy'])->name('komoditas.destroy');
    });

    Route::prefix('company')->group(function () {
        Route::get('', [CompanyController::class, 'index'])->name('company.index');
        Route::put('update', [CompanyController::class, 'update'])->name('company.update');
    });

    Route::prefix('jenisbiaya')->group(function () {
        Route::get('', [JenisBiayaController::class, 'index'])->name('jenisbiaya.index');        
        Route::get('/create', [JenisBiayaController::class, 'create'])->name('jenisbiaya.create');        
        Route::post('/create', [JenisBiayaController::class, 'store'])->name('jenisbiaya.store');        
        Route::get('/{jenisbiaya}/edit', [JenisBiayaController::class, 'edit'])->name('jenisbiaya.edit');       
        Route::put('/{jenisbiaya}/edit', [JenisBiayaController::class, 'update'])->name('jenisbiaya.update');       
        Route::post('/delete', [JenisBiayaController::class, 'delete'])->name('jenisbiaya.delete');       
        Route::delete('/delete', [JenisBiayaController::class, 'destroy'])->name('jenisbiaya.destroy');       
        
    });

    Route::prefix('fakturpajak')->group(function () {
        Route::get('', [NoFakturPajakController::class, 'index'])->name('fakturpajak.index');        
        Route::get('/create', [NoFakturPajakController::class, 'create'])->name('fakturpajak.create');        
        Route::post('/create', [NoFakturPajakController::class, 'store'])->name('fakturpajak.store');        
        Route::post('/import', [NoFakturPajakController::class, 'import'])->name('fakturpajak.import');        
        Route::get('/{fakturpajak}/edit', [NoFakturPajakController::class, 'edit'])->name('fakturpajak.edit');       
        Route::put('/{fakturpajak}/edit', [NoFakturPajakController::class, 'update'])->name('fakturpajak.update');       
        Route::get('/{fakturpajak}/status', [NoFakturPajakController::class, 'status'])->name('fakturpajak.status');       
        Route::post('/delete', [NoFakturPajakController::class, 'delete'])->name('fakturpajak.delete');       
        Route::delete('/destroy', [NoFakturPajakController::class, 'destroy'])->name('fakturpajak.destroy');  
        
        
        Route::post('/importnokpa', [NoFakturPajakController::class, 'importnokpa'])->name('fakturpajak.importnokpa');  
    });
});

Route::middleware('has.role')->prefix('pembelian')->group(function () {
    Route::prefix('pesananpembelian')->group(function () {
        Route::get('', [PesananPembelianController::class, 'index'])->name('pesananpembelian.index');
        Route::get('create', [PesananPembelianController::class, 'create'])->name('pesananpembelian.create');
        Route::post('create', [PesananPembelianController::class, 'store']);
        Route::get('{pesananpembelian}/edit', [PesananPembelianController::class, 'edit'])->name('pesananpembelian.edit');
        Route::put('{pesananpembelian}/edit', [PesananPembelianController::class, 'update'])->name('pesananpembelian.update');
        Route::post('delete', [PesananPembelianController::class, 'delete'])->name('pesananpembelian.delete');
        Route::delete('delete', [PesananPembelianController::class, 'destroy'])->name('pesananpembelian.destroy');
        Route::get('{pesananpembelian}/show', [PesananPembelianController::class, 'show'])->name('pesananpembelian.show');
        Route::get('caribarang', [PesananPembelianController::class, 'caribarang'])->name('pesananpembelian.caribarang');
        Route::post('setbarang', [PesananPembelianController::class, 'setbarang'])->name('pesananpembelian.setbarang');
        Route::post('editbarang', [PesananPembelianController::class, 'editbarang'])->name('pesananpembelian.editbarang');
        Route::post('updatebarang', [PesananPembelianController::class, 'updatebarang'])->name('pesananpembelian.updatebarang');

        Route::get('{pesananpembelian}/print_a4', [PesananPembelianController::class, 'print_a4'])->name('pesananpembelian.print_a4');

        Route::post('editdiskon', [PesananPembelianController::class, 'editdiskon'])->name('pesananpembelian.editdiskon');
        Route::post('updatediskon', [PesananPembelianController::class, 'updatediskon'])->name('pesananpembelian.updatediskon');

        Route::post('editppn', [PesananPembelianController::class, 'editppn'])->name('pesananpembelian.editppn');
        Route::post('updateppn', [PesananPembelianController::class, 'updateppn'])->name('pesananpembelian.updateppn');

        Route::post('inputtemppo', [PesananPembelianController::class, 'inputtemppo'])->name('pesananpembelian.inputtemppo');
        Route::post('loadtemppo', [PesananPembelianController::class, 'loadtemppo'])->name('pesananpembelian.loadtemppo');

        Route::delete('delete_detail', [PesananPembelianController::class, 'destroy_detail'])->name('pesananpembelian.destroy_detail');

        Route::post('hitungsubtotal', [PesananPembelianController::class, 'hitungsubtotal'])->name('pesananpembelian.hitungsubtotal');
        Route::post('hitungdiskon', [PesananPembelianController::class, 'hitungdiskon'])->name('pesananpembelian.hitungdiskon');
        Route::post('hitungtotal', [PesananPembelianController::class, 'hitungtotal'])->name('pesananpembelian.hitungtotal');
        Route::post('hitungppn', [PesananPembelianController::class, 'hitungppn'])->name('pesananpembelian.hitungppn');
        Route::post('hitungongkir', [PesananPembelianController::class, 'hitungongkir'])->name('pesananpembelian.hitungongkir');
        Route::post('hitunggrandtotal', [PesananPembelianController::class, 'hitunggrandtotal'])->name('pesananpembelian.hitunggrandtotal');
        Route::post('posting', [PesananPembelianController::class, 'posting'])->name('pesananpembelian.posting');
        Route::post('posted', [PesananPembelianController::class, 'posted'])->name('pesananpembelian.posted');

        Route::post('editstatus', [PesananPembelianController::class, 'editstatus'])->name('pesananpembelian.editstatus');


        // EDIT PESANAN PEMBELIAN
        Route::PUT('{pesananpembelian}/edit', [PesananPembelianController::class, 'update'])->name('pesananpembelian.update');
        Route::get('caribarangdetail/{id}', [PesananPembelianController::class, 'caribarangdetail'])->name('pesananpembelian.caribarangdetail');
        Route::post('setbarang', [PesananPembelianController::class, 'setbarang'])->name('pesananpembelian.setbarang');

        Route::get('{pesananpembelian}/edit', [PesananPembelianController::class, 'edit'])->name('pesananpembelian.edit');        
        Route::post('editbarangdetail', [PesananPembelianController::class, 'editBarangDetail'])->name('pesananpembelian.editbarangdetail');
        Route::post('updatebarangdetail', [PesananPembelianController::class, 'updateBarangDetail'])->name('pesananpembelian.updatebarangdetail');

        Route::post('editdiskondetail', [PesananPembelianController::class, 'editDiskonDetail'])->name('pesananpembelian.editdiskondetail');
        Route::post('updatediskondetail', [PesananPembelianController::class, 'updateDiskonDetail'])->name('pesananpembelian.updatediskondetail');

        Route::post('editppndetail', [PesananPembelianController::class, 'editPPNDetail'])->name('pesananpembelian.editppndetail');
        Route::post('updateppndetail', [PesananPembelianController::class, 'updatePPNDetail'])->name('pesananpembelian.updateppndetail');

        Route::post('inputpesanandetail', [PesananPembelianController::class, 'inputPesananDetail'])->name('pesananpembelian.inputpesanandetail');
        Route::post('loadpesanandetail', [PesananPembelianController::class, 'loadPesananDetail'])->name('pesananpembelian.loadpesanandetail');

        Route::delete('delete_pesanan_detail', [PesananPembelianController::class, 'destroyPesananDetail'])->name('pesananpembelian.destroy_pesanan_detail');

        Route::post('hitungsubtotaldetail', [PesananPembelianController::class, 'hitungSubTotalDetail'])->name('pesananpembelian.hitungsubtotaldetail');
        Route::post('hitungdiskondetail', [PesananPembelianController::class, 'hitungDiskonDetail'])->name('pesananpembelian.hitungdiskondetail');
        Route::post('hitungtotaldetail', [PesananPembelianController::class, 'hitungTotalDetail'])->name('pesananpembelian.hitungtotaldetail');
        Route::post('hitungppndetail', [PesananPembelianController::class, 'hitungPPNDetail'])->name('pesananpembelian.hitungppndetail');
        Route::post('hitungongkirdetail', [PesananPembelianController::class, 'hitungOngkirDetail'])->name('pesananpembelian.hitungongkirdetail');
        Route::post('hitunggrandtotaldetail', [PesananPembelianController::class, 'hitungGrandTotalDetail'])->name('pesananpembelian.hitunggrandtotaldetail');


    });


    Route::prefix('penerimaanbarang')->group(function () {
        Route::get('', [PenerimaanBarangController::class, 'index'])->name('penerimaanbarang.index');
        Route::get('{pesananpembelian}/create', [PenerimaanBarangController::class, 'create'])->name('penerimaanbarang.create');
        Route::post('{pesananpembelian}/create', [PenerimaanBarangController::class, 'store']);

        Route::get('{penerimaanbarang}/edit', [PenerimaanBarangController::class, 'edit'])->name('penerimaanbarang.edit');
        Route::put('{penerimaanbarang}/edit', [PenerimaanBarangController::class, 'update'])->name('penerimaanbarang.update');
        Route::get('{penerimaanbarang}/show', [PenerimaanBarangController::class, 'show'])->name('penerimaanbarang.show');
        Route::get('{penerimaanbarang}/showdata', [PenerimaanBarangController::class, 'showData'])->name('penerimaanbarang.showData');

        


        Route::post('delete', [PenerimaanBarangController::class, 'delete'])->name('penerimaanbarang.delete');
        Route::delete('delete', [PenerimaanBarangController::class, 'destroy'])->name('penerimaanbarang.destroy');
        Route::get('caribarang', [PenerimaanBarangController::class, 'caribarang'])->name('penerimaanbarang.caribarang');
        Route::post('setbarang', [PenerimaanBarangController::class, 'setbarang'])->name('penerimaanbarang.setbarang');
        Route::post('editbarang', [PenerimaanBarangController::class, 'editbarang'])->name('penerimaanbarang.editbarang');
        Route::post('updatebarang', [PenerimaanBarangController::class, 'updatebarang'])->name('penerimaanbarang.updatebarang');

        Route::post('inputtemppb', [PenerimaanBarangController::class, 'inputtemppb'])->name('penerimaanbarang.inputtemppb');
        Route::post('loadtemppb', [PenerimaanBarangController::class, 'loadtemppb'])->name('penerimaanbarang.loadtemppb');

        Route::delete('delete_detail', [PenerimaanBarangController::class, 'destroy_detail'])->name('penerimaanbarang.destroy_detail');

        Route::get('listpo', [PenerimaanBarangController::class, 'listpo'])->name('penerimaanbarang.listpo');

        Route::get('{penerimaanbarang}/inputexp', [PenerimaanBarangController::class, 'inputexp'])->name('penerimaanbarang.inputexp');
        Route::get('{penerimaanbarangdetail}/setexp', [PenerimaanBarangController::class, 'setexp'])->name('penerimaanbarang.setexp');

        Route::get('{penerimaanbarangdetail}/formsetexp', [PenerimaanBarangController::class, 'formsetexp'])->name('penerimaanbarang.formsetexp');
        Route::post('{penerimaanbarangdetail}/saveexp', [PenerimaanBarangController::class, 'saveexp'])->name('penerimaanbarang.saveexp');

        Route::post('hapusexp', [PenerimaanBarangController::class, 'hapusexp'])->name('penerimaanbarang.hapusexp');
        Route::delete('destroy_exp', [PenerimaanBarangController::class, 'destroy_exp'])->name('penerimaanbarang.destroy_exp');

        Route::get('{penerimaanbarang}/print_a5', [PenerimaanBarangController::class, 'print_a5'])->name('penerimaanbarang.print_a5');
    });

    Route::prefix('fakturpembelian')->group(function () {
        Route::get('', [FakturPembelianController::class, 'index'])->name('fakturpembelian.index');
        Route::get('{penerimaanbarang}/create', [FakturPembelianController::class, 'create'])->name('fakturpembelian.create');
        Route::post('{penerimaanbarang}/create', [FakturPembelianController::class, 'store']);
        Route::get('{fakturpembelian}/show', [FakturPembelianController::class, 'show'])->name('fakturpembelian.show');


        Route::post('delete', [FakturPembelianController::class, 'delete'])->name('fakturpembelian.delete');
        Route::delete('delete', [FakturPembelianController::class, 'destroy'])->name('fakturpembelian.destroy');
        Route::get('caribarang', [FakturPembelianController::class, 'caribarang'])->name('fakturpembelian.caribarang');
        Route::post('setbarang', [FakturPembelianController::class, 'setbarang'])->name('fakturpembelian.setbarang');
        Route::post('editbarang', [FakturPembelianController::class, 'editbarang'])->name('fakturpembelian.editbarang');
        Route::post('updatebarang', [FakturPembelianController::class, 'updatebarang'])->name('fakturpembelian.updatebarang');

        Route::post('inputtemppb', [FakturPembelianController::class, 'inputtemppb'])->name('fakturpembelian.inputtemppb');
        Route::post('loadtemppb', [FakturPembelianController::class, 'loadtemppb'])->name('fakturpembelian.loadtemppb');

        Route::post('editbiaya', [FakturPembelianController::class, 'editbiaya'])->name('fakturpembelian.editbiaya');
        Route::post('updatebiaya', [FakturPembelianController::class, 'updatebiaya'])->name('fakturpembelian.updatebiaya');
        Route::post('hitungbiaya', [FakturPembelianController::class, 'hitungbiaya'])->name('fakturpembelian.hitungbiaya');
        Route::post('hitunggrandtotal', [FakturPembelianController::class, 'hitunggrandtotal'])->name('fakturpembelian.hitunggrandtotal');

        Route::delete('delete_detail', [FakturPembelianController::class, 'destroy_detail'])->name('fakturpembelian.destroy_detail');

        Route::get('listpb', [FakturPembelianController::class, 'listpb'])->name('fakturpembelian.listpb');
        Route::get('{fakturpembelian}/print_a4', [FakturPembelianController::class, 'print_a4'])->name('fakturpembelian.print_a4');
    });
});

Route::middleware('has.role')->prefix('penjualan')->group(function () {
    Route::prefix('pesananpenjualan')->group(function () {
        Route::get('', [PesananPenjualanController::class, 'index'])->name('pesananpenjualan.index');
        Route::get('create', [PesananPenjualanController::class, 'create'])->name('pesananpenjualan.create');
        Route::post('create', [PesananPenjualanController::class, 'store']);                
        Route::get('{pesananpenjualan}/show', [PesananPenjualanController::class, 'show'])->name('pesananpenjualan.show');
        Route::post('delete', [PesananPenjualanController::class, 'delete'])->name('pesananpenjualan.delete');
        Route::delete('delete', [PesananPenjualanController::class, 'destroy'])->name('pesananpenjualan.destroy');

        Route::get('caribarang', [PesananPenjualanController::class, 'caribarang'])->name('pesananpenjualan.caribarang');
        Route::post('setbarang', [PesananPenjualanController::class, 'setbarang'])->name('pesananpenjualan.setbarang');

        Route::post('editbarang', [PesananPenjualanController::class, 'editbarang'])->name('pesananpenjualan.editbarang');
        Route::post('updatebarang', [PesananPenjualanController::class, 'updatebarang'])->name('pesananpenjualan.updatebarang');

        Route::post('editdiskon', [PesananPenjualanController::class, 'editdiskon'])->name('pesananpenjualan.editdiskon');
        Route::post('updatediskon', [PesananPenjualanController::class, 'updatediskon'])->name('pesananpenjualan.updatediskon');

        Route::post('editppn', [PesananPenjualanController::class, 'editppn'])->name('pesananpenjualan.editppn');
        Route::post('updateppn', [PesananPenjualanController::class, 'updateppn'])->name('pesananpenjualan.updateppn');

        Route::post('inputtempso', [PesananPenjualanController::class, 'inputtempso'])->name('pesananpenjualan.inputtempso');
        Route::post('loadtempso', [PesananPenjualanController::class, 'loadtempso'])->name('pesananpenjualan.loadtempso');

        Route::delete('delete_detail', [PesananPenjualanController::class, 'destroy_detail'])->name('pesananpenjualan.destroy_detail');

        Route::post('hitungsubtotal', [PesananPenjualanController::class, 'hitungsubtotal'])->name('pesananpenjualan.hitungsubtotal');
        Route::post('hitungdiskon', [PesananPenjualanController::class, 'hitungdiskon'])->name('pesananpenjualan.hitungdiskon');
        Route::post('hitungtotal', [PesananPenjualanController::class, 'hitungtotal'])->name('pesananpenjualan.hitungtotal');
        Route::post('hitungppn', [PesananPenjualanController::class, 'hitungppn'])->name('pesananpenjualan.hitungppn');
        Route::post('hitungongkir', [PesananPenjualanController::class, 'hitungongkir'])->name('pesananpenjualan.hitungongkir');
        Route::post('hitunggrandtotal', [PesananPenjualanController::class, 'hitunggrandtotal'])->name('pesananpenjualan.hitunggrandtotal');
        Route::post('posting', [PesananPenjualanController::class, 'posting'])->name('pesananpenjualan.posting');
        Route::post('posted', [PesananPenjualanController::class, 'posted'])->name('pesananpenjualan.posted');

        Route::post('editstatus', [PesananPenjualanController::class, 'editStatus'])->name('pesananpenjualan.editstatus');

        // EDIT PESANAN PENJUALAN
        Route::PUT('{pesananpenjualan}/edit', [PesananPenjualanController::class, 'update'])->name('pesananpenjualan.update');
        Route::get('caribarangdetail/{id}', [PesananPenjualanController::class, 'caribarangdetail'])->name('pesananpenjualan.caribarangdetail');
        Route::post('setbarang', [PesananPenjualanController::class, 'setbarang'])->name('pesananpenjualan.setbarang');

        Route::get('{pesananpenjualan}/edit', [PesananPenjualanController::class, 'edit'])->name('pesananpenjualan.edit');        
        Route::post('editbarangdetail', [PesananPenjualanController::class, 'editBarangDetail'])->name('pesananpenjualan.editbarangdetail');
        Route::post('updatebarangdetail', [PesananPenjualanController::class, 'updateBarangDetail'])->name('pesananpenjualan.updatebarangdetail');

        Route::post('editdiskondetail', [PesananPenjualanController::class, 'editDiskonDetail'])->name('pesananpenjualan.editdiskondetail');
        Route::post('updatediskondetail', [PesananPenjualanController::class, 'updateDiskonDetail'])->name('pesananpenjualan.updatediskondetail');

        Route::post('editppndetail', [PesananPenjualanController::class, 'editPPNDetail'])->name('pesananpenjualan.editppndetail');
        Route::post('updateppndetail', [PesananPenjualanController::class, 'updatePPNDetail'])->name('pesananpenjualan.updateppndetail');

        Route::post('inputpesanandetail', [PesananPenjualanController::class, 'inputPesananDetail'])->name('pesananpenjualan.inputpesanandetail');
        Route::post('loadpesanandetail', [PesananPenjualanController::class, 'loadPesananDetail'])->name('pesananpenjualan.loadpesanandetail');

        Route::delete('delete_pesanan_detail', [PesananPenjualanController::class, 'destroyPesananDetail'])->name('pesananpenjualan.destroy_pesanan_detail');

        Route::post('hitungsubtotaldetail', [PesananPenjualanController::class, 'hitungSubTotalDetail'])->name('pesananpenjualan.hitungsubtotaldetail');
        Route::post('hitungdiskondetail', [PesananPenjualanController::class, 'hitungDiskonDetail'])->name('pesananpenjualan.hitungdiskondetail');
        Route::post('hitungtotaldetail', [PesananPenjualanController::class, 'hitungTotalDetail'])->name('pesananpenjualan.hitungtotaldetail');
        Route::post('hitungppndetail', [PesananPenjualanController::class, 'hitungPPNDetail'])->name('pesananpenjualan.hitungppndetail');
        Route::post('hitungongkirdetail', [PesananPenjualanController::class, 'hitungOngkirDetail'])->name('pesananpenjualan.hitungongkirdetail');
        Route::post('hitunggrandtotaldetail', [PesananPenjualanController::class, 'hitungGrandTotalDetail'])->name('pesananpenjualan.hitunggrandtotaldetail');

        // PRINT PENJUALAN
        Route::get('{pesananpenjualan}/print_a4', [PesananPenjualanController::class, 'print_a4'])->name('pesananpenjualan.print_a4');


    });

    Route::prefix('pengirimanbarang')->group(function () {
        Route::get('', [PengirimanBarangController::class, 'index'])->name('pengirimanbarang.index');
        Route::get('{pesananpenjualan}/create', [PengirimanBarangController::class, 'create'])->name('pengirimanbarang.create');
        Route::post('{pesananpenjualan}/create', [PengirimanBarangController::class, 'store']);

        Route::get('{pengirimanbarang}/edit', [PengirimanBarangController::class, 'edit'])->name('pengirimanbarang.edit');
        Route::put('{pengirimanbarang}/edit', [PengirimanBarangController::class, 'update'])->name('pengirimanbarang.update');
        Route::get('{pengirimanbarang}/show', [PengirimanBarangController::class, 'show'])->name('pengirimanbarang.show');
        Route::get('{pengirimanbarang}/showData', [PengirimanBarangController::class, 'showData'])->name('pengirimanbarang.showData');

        Route::post('delete', [PengirimanBarangController::class, 'delete'])->name('pengirimanbarang.delete');
        Route::delete('delete', [PengirimanBarangController::class, 'destroy'])->name('pengirimanbarang.destroy');
        Route::get('caribarang', [PengirimanBarangController::class, 'caribarang'])->name('pengirimanbarang.caribarang');
        Route::post('setbarang', [PengirimanBarangController::class, 'setbarang'])->name('pengirimanbarang.setbarang');
        Route::post('editbarang', [PengirimanBarangController::class, 'editbarang'])->name('pengirimanbarang.editbarang');
        Route::post('updatebarang', [PengirimanBarangController::class, 'updatebarang'])->name('pengirimanbarang.updatebarang');

        Route::post('inputtempsj', [PengirimanBarangController::class, 'inputtempsj'])->name('pengirimanbarang.inputtempsj');
        Route::post('loadtempsj', [PengirimanBarangController::class, 'loadtempsj'])->name('pengirimanbarang.loadtempsj');

        Route::delete('delete_detail', [PengirimanBarangController::class, 'destroy_detail'])->name('pengirimanbarang.destroy_detail');

        Route::get('listso', [PengirimanBarangController::class, 'listso'])->name('pengirimanbarang.listso');

        Route::get('{pengirimanbarang}/inputexp', [PengirimanBarangController::class, 'inputexp'])->name('pengirimanbarang.inputexp');
        Route::get('{pengirimanbarangdetail}/setexp', [PengirimanBarangController::class, 'setexp'])->name('pengirimanbarang.setexp');
        Route::get('{pengirimanbarangdetail}/listexp', [PengirimanBarangController::class, 'listexp'])->name('pengirimanbarang.listexp');
        Route::get('{stokExp}/{pengirimanbarangdetail}/formsetexp', [PengirimanBarangController::class, 'formsetexp'])->name('pengirimanbarang.formsetexp');
        Route::post('{stokExp}/{pengirimanbarangdetail}/saveexp', [PengirimanBarangController::class, 'saveexp'])->name('pengirimanbarang.saveexp');
        Route::post('hapusexp', [PengirimanBarangController::class, 'hapusexp'])->name('pengirimanbarang.hapusexp');
        Route::delete('destroy_exp', [PengirimanBarangController::class, 'destroy_exp'])->name('pengirimanbarang.destroy_exp');

        Route::get('{pengirimanbarang}/print_a5', [PengirimanBarangController::class, 'print_a5'])->name('pengirimanbarang.print_a5');
    });


    Route::prefix('fakturpenjualan')->group(function () {
        Route::get('', [FakturPenjualanController::class, 'index'])->name('fakturpenjualan.index');
        Route::get('{pengirimanbarang}/create', [FakturPenjualanController::class, 'create'])->name('fakturpenjualan.create');
        Route::post('{pengirimanbarang}/create', [FakturPenjualanController::class, 'store']);

        Route::get('{fakturpenjualan}/edit', [FakturPenjualanController::class, 'edit'])->name('fakturpenjualan.edit');
        Route::post('{fakturpenjualan}/update', [FakturPenjualanController::class, 'update'])->name('fakturpenjualan.update');

        Route::get('{fakturpenjualan}/show', [FakturPenjualanController::class, 'show'])->name('fakturpenjualan.show');
        Route::get('{fakturpenjualan}/showdata', [FakturPenjualanController::class, 'showdata'])->name('fakturpenjualan.showdata');

        Route::post('delete', [FakturPenjualanController::class, 'delete'])->name('fakturpenjualan.delete');
        Route::delete('delete', [FakturPenjualanController::class, 'destroy'])->name('fakturpenjualan.destroy');
        Route::get('caribarang', [FakturPenjualanController::class, 'caribarang'])->name('fakturpenjualan.caribarang');
        Route::post('setbarang', [FakturPenjualanController::class, 'setbarang'])->name('fakturpenjualan.setbarang');
        Route::post('editbarang', [FakturPenjualanController::class, 'editbarang'])->name('fakturpenjualan.editbarang');
        Route::post('updatebarang', [FakturPenjualanController::class, 'updatebarang'])->name('fakturpenjualan.updatebarang');

        Route::post('editbiaya', [FakturPenjualanController::class, 'editbiaya'])->name('fakturpenjualan.editbiaya');
        Route::post('updatebiaya', [FakturPenjualanController::class, 'updatebiaya'])->name('fakturpenjualan.updatebiaya');
        Route::post('hitungbiaya', [FakturPenjualanController::class, 'hitungbiaya'])->name('fakturpenjualan.hitungbiaya');
        Route::post('hitunggrandtotal', [FakturPenjualanController::class, 'hitunggrandtotal'])->name('fakturpenjualan.hitunggrandtotal');

        Route::post('inputtempsj', [FakturPenjualanController::class, 'inputtemppb'])->name('fakturpenjualan.inputtempsj');
        Route::post('loadtempsj', [FakturPenjualanController::class, 'loadtemppb'])->name('fakturpenjualan.loadtempsj');

        Route::delete('delete_detail', [FakturPenjualanController::class, 'destroy_detail'])->name('fakturpenjualan.destroy_detail');

        Route::get('listsj', [FakturPenjualanController::class, 'listsj'])->name('fakturpenjualan.listsj');

        Route::post('getnokpa', [FakturPenjualanController::class, 'getNoKpa'])->name('fakturpenjualan.getnokpa');

        // cn

        Route::get('{fakturpenjualan}/print_a4', [FakturPenjualanController::class, 'print_a4'])->name('fakturpenjualan.print_a4');
        Route::get('{fakturpenjualan}/EditCN', [FakturPenjualanController::class, 'editCN'])->name('fakturpenjualan.editCN');
        Route::POST('{fakturpenjualandetail}/EditCN', [FakturPenjualanController::class, 'createCN'])->name('fakturpenjualan.editCN');
        Route::PUT('{fakturpenjualandetail}/updateCN', [FakturPenjualanController::class, 'updateCN'])->name('fakturpenjualan.updateCN');

        // kwitansi
        Route::get('{fakturpenjualan}/kwitansi', [FakturPenjualanController::class, 'kwitansi'])->name('fakturpenjualan.kwitansi');

        // ============================================== BIAYA LAIN - LAIN ===============================================================
        Route::get('{fakturpenjualan}/biayalain', [BiayaLainController::class, 'index'])->name('fakturpenjualan.biayalain.index');
        Route::post('/biayalain/datatable', [BiayaLainController::class, 'datatables'])->name('fakturpenjualan.biayalain.datatable');
        Route::post('/biayalain/store', [BiayaLainController::class, 'store'])->name('fakturpenjualan.biayalain.store');
        Route::post('/biayalain/edit', [BiayaLainController::class, 'edit'])->name('fakturpenjualan.biayalain.edit');
        Route::post('/biayalain/update', [BiayaLainController::class, 'update'])->name('fakturpenjualan.biayalain.ubah');
        Route::post('/biayalain/delete', [BiayaLainController::class, 'destroy'])->name('fakturpenjualan.biayalain.destroy');

        //==============================================  LABA RUGI =======================================================================
        Route::get('{fakturpenjualan}/labarugi', [LabaRugiController::class, 'show'])->name('fakturpenjualan.labarugi.show');
      
    });

    Route::prefix('pembayaranhutang')->group(function () {
        Route::get('', [PembayaranHutangController::class, 'index'])->name('pembayaranhutang.index');
    });
});

Route::middleware('has.role')->prefix('pembayaran')->group(function () {
    Route::prefix('pembayaranhutang')->group(function () {
        Route::get('', [PembayaranHutangController::class, 'index'])->name('pembayaranhutang.index');
        Route::get('listhutang', [PembayaranHutangController::class, 'listhutang'])->name('pembayaranhutang.listhutang');
        Route::get('{hutang}/create', [PembayaranHutangController::class, 'create'])->name('pembayaranhutang.create');
        Route::get('{hutang}/create', [PembayaranHutangController::class, 'create'])->name('pembayaranhutang.create');
        Route::post('{hutang}/create', [PembayaranHutangController::class, 'store']);
        Route::post('show', [PembayaranHutangController::class, 'show'])->name('pembayaranhutang.show');
        Route::post('delete', [PembayaranHutangController::class, 'delete'])->name('pembayaranhutang.delete');
        Route::delete('delete', [PembayaranHutangController::class, 'destroy'])->name('pembayaranhutang.destroy');
    });

    Route::prefix('pembayaranpiutang')->group(function () {
        Route::post('datatable', [PembayaranPiutangController::class, 'datatable'])->name('piutang.datatable');
        Route::get('{id}/create', [PembayaranPiutangController::class, 'create'])->name('pembayaranpiutang.create');
        Route::post('{id}/store', [PembayaranPiutangController::class, 'store'])->name('pembayaranpiutang.store');
        Route::get('', [PembayaranPiutangController::class, 'index'])->name('pembayaranpiutang.index');
        Route::get('listpiutang', [PembayaranPiutangController::class, 'listpiutang'])->name('pembayaranpiutang.listpiutang');
        Route::post('show', [PembayaranPiutangController::class, 'show'])->name('pembayaranpiutang.show');
        Route::post('delete', [PembayaranPiutangController::class, 'delete'])->name('pembayaranpiutang.delete');
        Route::delete('delete', [PembayaranPiutangController::class, 'destroy'])->name('pembayaranpiutang.destroy');
    });
});

Route::middleware('has.role')->prefix('laporan')->group(function () {
    Route::prefix('laporanstok')->group(function () {
        Route::get('', [LaporanStokController::class, 'index'])->name('laporanstok.index');
        Route::get('stokproduk', [LaporanStokController::class, 'stokproduk'])->name('laporanstok.stokproduk');
        Route::get('{product}/detailstok', [LaporanStokController::class, 'detailstok'])->name('laporanstok.detailstok');
        Route::get('{stokexp}/{product}/detailexp', [LaporanStokController::class, 'detailexp'])->name('laporanstok.detailexp');
        Route::get('kartustok', [LaporanStokController::class, 'kartustok'])->name('laporanstok.kartustok');
        Route::get('{product}/kartustok', [LaporanStokController::class, 'kartustokdetail'])->name('laporanstok.kartustokdetail');
        Route::get('expstok', [LaporanStokController::class, 'expstok'])->name('laporanstok.expstok');
        Route::post('stokproduk/export', [LaporanStokController::class, 'exportStok'])->name('laporanstok.export');
        Route::post('expstokresult', [LaporanStokController::class, 'expstokresult'])->name('laporanstok.expstokresult');
        Route::post('kartustokexport', [LaporanStokController::class, 'exportkartustok'])->name('laporanstok.exportkartustok');        
        
        Route::get('adjustmentstok', [LaporanAdjustmentStokController::class, 'filter'])->name('laporanstok.adjustmentstok');
        Route::post('adjustmentstok/result', [LaporanAdjustmentStokController::class, 'result'])->name('laporanstok.adjustmentstokresult');
        Route::post('adjustmentstok/export', [LaporanAdjustmentStokController::class, 'export'])->name('laporanstok.adjustmentstokexport');

        Route::get('refresh', [InventoryController::class, 'update'])->name('laporanstok.refresh');
        Route::get('singkronisasi', [LaporanAdjustmentStokController::class, 'sync'])->name('laporanstok.singkronisasi');


        
    });


    Route::prefix('laporanpenjualan')->group(function () {

        Route::get('', [LaporanPenjualanController::class, 'index'])->name('laporanpenjualan.index');
        Route::get('penjualan', [LaporanPenjualanController::class, 'filterPenjualan'])->name('laporanpenjualan.filterpenjualan');
        Route::get('penjualandetail', [LaporanPenjualanController::class, 'filterPenjualanDetail'])->name('laporanpenjualan.filterpenjualandetail');
        Route::get('penjualancn', [LaporanPenjualanController::class, 'filterPenjualanCN'])->name('laporanpenjualan.filterpenjualancn');        

        Route::post('penjualan', [LaporanPenjualanController::class, 'filterDataPenjualan'])->name('laporanpenjualan.filterdatapenjualan');
        Route::post('penjualan/export', [LaporanPenjualanController::class, 'exportPenjualan'])->name('laporanpenjualan.exportpenjualan');
        Route::post('penjualandetail', [LaporanPenjualanController::class, 'filterDataPenjualanDetail'])->name('laporanpenjualan.filterdatapenjualandetail');
        Route::post('penjualandetail/export', [LaporanPenjualanController::class, 'exportPenjualanDetail'])->name('laporanpenjualan.exportpenjualandetail');
        Route::post('penjualancn', [LaporanPenjualanController::class, 'filterDataPenjualanCN'])->name('laporanpenjualan.filterdatapenjualancn');
        Route::post('penjualancn/export', [LaporanPenjualanController::class, 'exportPenjualanCN'])->name('laporanpenjualan.exportpenjualancn');        
        
    });

    Route::prefix('laporanpembayaran')->group(function () {

        Route::get('', [LaporanPembayaranController::class, 'index'])->name('laporanpembayaran.index');
        Route::get('pembayaranhutang', [LaporanPembayaranController::class, 'filterHutang'])->name('laporanpembayaran.filterpembayaranhutang');        
        Route::get('pembayaranhutangdetail', [LaporanPembayaranController::class, 'filterHutangDetail'])->name('laporanpembayaran.filterpembayaranhutangdetail');        
        Route::get('pembayaranpiutang', [LaporanPembayaranController::class, 'filterPiutang'])->name('laporanpembayaran.filterpembayaranpiutang');
        Route::get('pembayaranpiutangdetail', [LaporanPembayaranController::class, 'filterPiutangDetail'])->name('laporanpembayaran.filterpembayaranpiutangdetail');
        Route::get('logtoleransi', [LaporanPembayaranController::class, 'logToleransi'])->name('laporanpembayaran.filterlogtoleransi');

        Route::post('logtoleransi', [LaporanPembayaranController::class, 'filterLogToleransi'])->name('laporanpembayaran.filterlogtoleransi');
        Route::post('pembayaranhutang', [LaporanPembayaranController::class, 'filterDataHutang'])->name('laporanpembayaran.filterdatapembayaranhutang');
        Route::post('pembayaranhutang/export', [LaporanPembayaranController::class, 'exportPembayaranHutang'])->name('laporanpembayaran.exportpembayaranhutang');
        Route::post('pembayaranhutangdetail', [LaporanPembayaranController::class, 'filterDataHutangDetail'])->name('laporanpembayaran.filterdatapembayaranhutangdetail');
        Route::post('pembayaranhutangdetail/export', [LaporanPembayaranController::class, 'exportPembayaranHutangDetail'])->name('laporanpembayaran.exportpembayaranhutangdetail');

        Route::post('pembayaranpiutang', [LaporanPembayaranController::class, 'filterDataPiutang'])->name('laporanpembayaran.filterpembayaranpiutang');
        Route::post('pembayaranpiutang/export', [LaporanPembayaranController::class, 'exportPembayaranPiutang'])->name('laporanpembayaran.exportpembayaranpiutang'); 
        Route::post('pembayaranpiutangdetail', [LaporanPembayaranController::class, 'filterPembayaranPiutangDetail'])->name('laporanpembayaran.filterpembayaranpiutangdetail');
        Route::post('pembayaranpiutangdetail/export', [LaporanPembayaranController::class, 'exportPembayaranPiutangDetail'])->name('laporanpembayaran.exportpembayaranpiutangdetail');                
        
    });

    Route::prefix('laporanpembelian')->group(function () {

        // GET
        Route::get('', [LaporanPembelianController::class, 'index'])->name('laporanpembelian.index');
        Route::get('pembelian', [LaporanPembelianController::class, 'filterPembelian'])->name('laporanpembelian.filterpembelian');
        Route::get('pembeliandetail', [LaporanPembelianController::class, 'filterPembelianDetail'])->name('laporanpembelian.filterpembeliandetail');

        // POST
        Route::post('pembelian', [LaporanPembelianController::class, 'filterDataPembelian'])->name('laporanpembelian.filterdatapembelian');
        Route::post('pembelian/export', [LaporanPembelianController::class, 'exportPembelian'])->name('laporanpembelian.exportpembelian');
        Route::post('pembeliandetail', [LaporanPembelianController::class, 'filterDataPembelianDetail'])->name('laporanpembelian.filterdatapembeliandetail');
        Route::post('pembeliandetail/export', [LaporanPembelianController::class, 'exportPembelianDetail'])->name('laporanpembelian.exportpembeliandetail');

    });

    Route::prefix('laporanhutangpiutang')->group(function () {
             // GET
        Route::get('', [LaporanHutangPiutangController::class, 'index'])->name('laporanhutangpiutang.index');
        Route::get('hutang', [LaporanHutangPiutangController::class, 'hutang'])->name('laporanhutangpiutang.hutang');
        Route::get('piutang', [LaporanHutangPiutangController::class, 'piutang'])->name('laporanhutangpiutang.piutang');


        Route::post('hutang', [LaporanHutangPiutangController::class, 'filterHutang'])->name('laporanhutangpiutang.filterhutang');
        Route::post('hutang/export', [LaporanHutangPiutangController::class, 'exportHutang'])->name('laporanhutangpiutang.exporthutang');
        Route::post('piutang', [LaporanHutangPiutangController::class, 'filterPiutang'])->name('laporanhutangpiutang.filterpiutang');
        Route::post('piutang/export', [LaporanHutangPiutangController::class, 'exportPiutang'])->name('laporanhutangpiutang.exportpiutang');
    });


    Route::prefix('laporanbiayaoperational')->group(function () {
                // GET
        Route::get('', [LaporanBiayaOperationalController::class, 'index'])->name('laporanbiayaoperational.index');        
        Route::post('/result', [LaporanBiayaOperationalController::class, 'filter'])->name('laporanbiayaoperational.filter');
        Route::post('/export', [LaporanBiayaOperationalController::class, 'export'])->name('laporanbiayaoperational.export');        
    });

    Route::prefix('laporanfakturpajak')->group(function () {
        
        // GET
        Route::get('', [LaporanFakturPajakController::class, 'index'])->name('laporanfakturpajak.index');        
        Route::post('/result', [LaporanFakturPajakController::class, 'result'])->name('laporanfakturpajak.filter');
        Route::get('/{id}/detail', [LaporanFakturPajakController::class, 'detail'])->name('laporanfakturpajak.detail');

        Route::post('/exportfaktur', [LaporanFakturPajakController::class, 'exportFaktur'])->name('laporanfakturpajak.exportfaktur');        
        Route::post('/exportlogfaktur', [LaporanFakturPajakController::class, 'exportLogFaktur'])->name('laporanfakturpajak.exportlogfaktur');        
    });


    Route::prefix('laporanlabarugi')->group(function () {
        
        // GET
        Route::get('', [LaporanLabaRugiController::class, 'index'])->name('laporanlabarugi.index');        
        Route::post('/result', [LaporanLabaRugiController::class, 'datatable'])->name('laporanlabarugi.datatable');
        Route::get('/{id}/show', [LaporanLabaRugiController::class, 'show'])->name('laporanlabarugi.show');

        Route::post('/print', [LaporanLabaRugiController::class, 'print'])->name('laporanlabarugi.print');        
        
    });

    Route::prefix('laporansales')->group(function () {
    
        Route::get('', [LaporanSalesController::class, 'index'])->name('laporansales.index');        
        Route::post('/datatable', [LaporanSalesController::class, 'datatable'])->name('laporansales.datatable');


        Route::get('/{id}/show', [LaporanSalesController::class, 'show'])->name('laporansales.show');

        Route::post('/print', [LaporanSalesController::class, 'print'])->name('laporansales.print');        
        
    });


});

Route::middleware('has.role')->prefix('konversi')->group(function () {
    Route::prefix('konversisatuan')->group(function () {
        Route::get('', [KonversiController::class, 'index'])->name('konversisatuan.index');
        Route::get('create', [KonversiController::class, 'create'])->name('konversisatuan.create');
        Route::post('store', [KonversiController::class, 'store'])->name('konversisatuan.store');


        Route::get('{id}/expdate', [KonversiController::class, 'pilihExp'])->name('konversisatuan.pilihexp');
        Route::post('setqty', [KonversiController::class, 'setQty'])->name('konversisatuan.setqty');
        Route::post('inputqty', [KonversiController::class, 'inputQty'])->name('konversisatuan.inputqty');

        Route::get('caribarang', [KonversiController::class, 'caribarang'])->name('konversisatuan.caribarang');
        Route::post('setbarang', [KonversiController::class, 'setbarang'])->name('konversisatuan.setbarang');        

        Route::post('submititem', [KonversiController::class, 'submitItem'])->name('konversisatuan.inputtempkonversi');
        Route::post('loadtempkonversi', [KonversiController::class, 'loadKonversi'])->name('konversisatuan.loadkonversi');

        Route::post('editbarang', [KonversiController::class, 'editbarang'])->name('konversisatuan.editbarang');
        Route::post('updatebarang', [KonversiController::class, 'updatebarang'])->name('konversisatuan.updatebarang');

        Route::delete('delete_detail', [KonversiController::class, 'destroy_detail'])->name('konversisatuan.destroy_detail');

        Route::post('delete', [KonversiController::class, 'delete'])->name('konversisatuan.delete');
        Route::delete('delete', [KonversiController::class, 'destroy'])->name('konversisatuan.destroy');

        Route::get('{konversisatuan}/show', [KonversiController::class, 'show'])->name('konversisatuan.show');
                
        
    });

});

Route::middleware('has.role')->prefix('canvassing')->group(function () {
    Route::prefix('canvassing')->group(function () {
        Route::get('', [CanvassingPesananController::class, 'index'])->name('canvassing.index');
        Route::get('create', [CanvassingPesananController::class, 'create'])->name('canvassing.create');
        Route::post('create', [CanvassingPesananController::class, 'store'])->name('canvassing.create');
        

        Route::get('caribarang', [CanvassingPesananController::class, 'caribarang'])->name('canvassing.caribarang');
        Route::post('setbarang', [CanvassingPesananController::class, 'setbarang'])->name('canvassing.setbarang');        

        Route::post('inputtempcanvas', [CanvassingPesananController::class, 'inputTempCanvas'])->name('canvassing.inputtempcanvas');        
        Route::post('loadtempcanvas', [CanvassingPesananController::class, 'loadTempCanvas'])->name('canvassing.loadtempcanvas');        

        Route::post('editbarang', [CanvassingPesananController::class, 'editbarang'])->name('canvassing.editbarang');
        Route::post('updatebarang', [CanvassingPesananController::class, 'updatebarang'])->name('canvassing.updatebarang');

        Route::delete('delete_detail', [CanvassingPesananController::class, 'destroy_detail'])->name('canvassing.destroy_detail');

        Route::get('{canvassing}/show', [CanvassingPesananController::class, 'show'])->name('canvassing.show');

        Route::post('delete', [CanvassingPesananController::class, 'delete'])->name('canvassing.delete');
        Route::delete('delete', [CanvassingPesananController::class, 'destroy'])->name('canvassing.destroy');
        

    });

    Route::prefix('canvassingpengembalian')->group(function () {
        Route::get('', [CanvassingPengembalianController::class, 'index'])->name('canvassingpengembalian.index');
        Route::get('listcanvas', [CanvassingPengembalianController::class, 'listcanvas'])->name('canvassingpengembalian.listcanvas');
        Route::get('{canvassingpengembalian}/create', [CanvassingPengembalianController::class, 'create'])->name('canvassingpengembalian.create');
        Route::POST('store', [CanvassingPengembalianController::class, 'store'])->name('canvassingpengembalian.store');

        Route::get('caribarang', [CanvassingPengembalianController::class, 'caribarang'])->name('canvassingpengembalian.caribarang');
        Route::post('setbarang', [CanvassingPengembalianController::class, 'setbarang'])->name('canvassingpengembalian.setbarang');        

        Route::post('inputtempcanvas', [CanvassingPengembalianController::class, 'inputTempCanvas'])->name('canvassingpengembalian.inputtempcanvas');        
        Route::post('loadtempcanvas', [CanvassingPengembalianController::class, 'loadTempCanvas'])->name('canvassingpengembalian.loadtempcanvas');        

        Route::post('editbarang', [CanvassingPengembalianController::class, 'editbarang'])->name('canvassingpengembalian.editbarang');
        Route::post('updatebarang', [CanvassingPengembalianController::class, 'updatebarang'])->name('canvassingpengembalian.updatebarang');

        Route::delete('delete_detail', [CanvassingPengembalianController::class, 'destroy_detail'])->name('canvassingpengembalian.destroy_detail');

        Route::post('delete', [CanvassingPengembalianController::class, 'delete'])->name('canvassingpengembalian.delete');
        Route::delete('delete', [CanvassingPengembalianController::class, 'destroy'])->name('canvassingpengembalian.destroy');

        Route::get('{canvassingpengembalian}/show', [CanvassingPengembalianController::class, 'show'])->name('canvassingpengembalian.show');

        
    });
});

Route::middleware('has.role')->prefix('adjustment')->group(function () {
    Route::prefix('adjustmentstok')->group(function () {
        Route::get('', [AdjustmentStokController::class, 'index'])->name('adjustmentstok.index');        

        Route::prefix('expired')->group(function () {
            Route::get('', [AdjustmentStokController::class, 'expired'])->name('stokexpired.expired'); 
            Route::post('/import', [AdjustmentStokController::class, 'importExpired'])->name('stokexpired.import');  
            Route::post('/importrevisi', [AdjustmentStokController::class, 'importRevisiExpired'])->name('stokexpired.importrevisi');               
        });
    
        Route::prefix('nonexpired')->group(function () {
            Route::get('', [AdjustmentStokController::class, 'nonexpired'])->name('stoknonexpired.nonexpired');        
            Route::post('/import', [AdjustmentStokController::class, 'importNonExpired'])->name('stoknonexpired.import');        
        });
    });
});

Route::middleware('has.role')->prefix('biaya')->group(function () {
        Route::prefix('biayaoperational')->group(function () {
            Route::get('', [BiayaOperationalController::class, 'index'])->name('biayaoperational.index');        
            Route::get('/create', [BiayaOperationalController::class, 'create'])->name('biayaoperational.create');        
            Route::post('/create', [BiayaOperationalController::class, 'store'])->name('biayaoperational.store');        
            Route::get('/{biayaoperational}/edit', [BiayaOperationalController::class, 'edit'])->name('biayaoperational.edit');       
            Route::put('/{biayaoperational}/edit', [BiayaOperationalController::class, 'update'])->name('biayaoperational.update');                   
            Route::post('/delete', [BiayaOperationalController::class, 'delete'])->name('biayaoperational.delete');       
            Route::delete('/delete', [BiayaOperationalController::class, 'destroy'])->name('biayaoperational.destroy');       
            
        });
});

Route::middleware('has.role')->prefix('sales')->group(function () {
    Route::prefix('kunjungansales')->group(function () {
        Route::post('/datatable', [KunjunganSalesController::class, 'datatable'])->name('kunjungansales.datatable'); 
        Route::get('/show/{kunjungansales}', [KunjunganSalesController::class, 'show'])->name('kunjungansales.show');        
        Route::get('', [KunjunganSalesController::class, 'index'])->name('kunjungansales.index');          
        
         
        Route::get('/create', [KunjunganSalesController::class, 'create'])->name('kunjungansales.create');        
        Route::post('/store', [KunjunganSalesController::class, 'store'])->name('kunjungansales.store');        
        Route::get('/{kunjungansales}/edit', [KunjunganSalesController::class, 'edit'])->name('kunjungansales.edit');       
        Route::PUT('/{kunjungansales}/update', [KunjunganSalesController::class, 'update'])->name('kunjungansales.update');                   
        Route::post('/delete', [KunjunganSalesController::class, 'delete'])->name('kunjungansales.delete');       
        Route::delete('/delete', [KunjunganSalesController::class, 'destroy'])->name('kunjungansales.destroy');       
        
    });

    Route::prefix('penjualansales')->group(function () {
        Route::post('/datatablepenjualan', [KunjunganSalesController::class, 'datatablepenjualan'])->name('sales.datatablepenjualan'); 
        Route::get('/show/{kunjungansales}', [KunjunganSalesController::class, 'show'])->name('penjualansales.show');        
        Route::get('', [KunjunganSalesController::class, 'indexpenjulaan'])->name('penjualansales.index');          
        
         
        // Route::get('/create', [KunjunganSalesController::class, 'create'])->name('kunjungansales.create');        
        // Route::post('/store', [KunjunganSalesController::class, 'store'])->name('kunjungansales.store');        
        // Route::get('/{kunjungansales}/edit', [KunjunganSalesController::class, 'edit'])->name('kunjungansales.edit');       
        // Route::PUT('/{kunjungansales}/update', [KunjunganSalesController::class, 'update'])->name('kunjungansales.update');                   
        // Route::post('/delete', [KunjunganSalesController::class, 'delete'])->name('kunjungansales.delete');       
        // Route::delete('/delete', [KunjunganSalesController::class, 'destroy'])->name('kunjungansales.destroy');       
        
    });


});

Route::middleware('has.role')->prefix('teknisi')->group(function () {
    Route::prefix('maintenanceproduk')->group(function () {
        Route::post('/datatable', [MaintenanceController::class, 'datatable'])->name('maintenanceproduk.datatable'); 
        Route::get('/show/{maintenanceproduk}', [MaintenanceController::class, 'show'])->name('maintenanceproduk.show');        
        Route::get('', [MaintenanceController::class, 'index'])->name('maintenanceproduk.index');         
        
        //############################### CREATE ##########################################################################
        //=============================== Before Action ===================================================================
        Route::post('/submitbefore', [MaintenanceController::class, 'submitBefore'])->name('maintenanceproduk.submitbefore');
        Route::post('/editbefore', [MaintenanceController::class, 'editBefore'])->name('maintenanceproduk.editbefore');
        Route::post('/updatebefore', [MaintenanceController::class, 'updateBefore'])->name('maintenanceproduk.updatebefore');
        Route::post('/deletebefore', [MaintenanceController::class, 'deleteBefore'])->name('maintenanceproduk.deletebefore');
        Route::post('/tabelbefore', [MaintenanceController::class, 'tabelBefore'])->name('maintenanceproduk.tabelbefore');

         //=============================== After Action ===================================================================
         Route::post('/submitafter', [MaintenanceController::class, 'submitAfter'])->name('maintenanceproduk.submitafter');
         Route::post('/editafter', [MaintenanceController::class, 'editAfter'])->name('maintenanceproduk.editafter');
         Route::post('/updateafter', [MaintenanceController::class, 'updateAfter'])->name('maintenanceproduk.updateafter');
         Route::post('/deleteafter', [MaintenanceController::class, 'deleteAfter'])->name('maintenanceproduk.deleteafter');
         Route::post('/tabelafter', [MaintenanceController::class, 'tabelAfter'])->name('maintenanceproduk.tabelafter');
        
         
        Route::get('/create', [MaintenanceController::class, 'create'])->name('maintenanceproduk.create');        
        Route::post('/store', [MaintenanceController::class, 'store'])->name('maintenanceproduk.store'); 

        // ##################################### EDIT ###################################################################
        // ==================================== Before Action ===========================================================
        Route::post('/editsubmitbefore', [MaintenanceController::class, 'EditsubmitBefore'])->name('maintenanceprodukedit.submitbefore');
        Route::post('/editeditbefore', [MaintenanceController::class, 'editDataBefore'])->name('maintenanceprodukedit.editbefore');
        Route::post('/editupdatebefore', [MaintenanceController::class, 'updateDataBefore'])->name('maintenanceprodukedit.updatebefore');
        Route::post('/editdeletebefore', [MaintenanceController::class, 'destroyEditBefore'])->name('maintenanceprodukedit.deletebefore');
        Route::post('/edittabelbefore', [MaintenanceController::class, 'loadTabelEditBefore'])->name('maintenanceprodukedit.tabelbefore');

         //=============================== After Action ===================================================================
         Route::post('/editsubmitafter', [MaintenanceController::class, 'EditsubmitAfter'])->name('maintenanceprodukedit.submitafter');
         Route::post('/editeditafter', [MaintenanceController::class, 'editDataAfter'])->name('maintenanceprodukedit.editafter');
         Route::post('/editupdateafter', [MaintenanceController::class, 'updateDataAfter'])->name('maintenanceprodukedit.updateafter');
         Route::post('/editdeleteafter', [MaintenanceController::class, 'destroyEditAfter'])->name('maintenanceprodukedit.deleteafter');
         Route::post('/edittabelafter', [MaintenanceController::class, 'loadTabelEditAfter'])->name('maintenanceprodukedit.tabelafter');

         Route::get('/{maintenanceproduk}/edit', [MaintenanceController::class, 'edit'])->name('maintenanceproduk.edit');       
         Route::PUT('/{maintenanceproduk}/update', [MaintenanceController::class, 'update'])->name('maintenanceproduk.update');                   
        
         Route::post('/delete', [MaintenanceController::class, 'destroy'])->name('maintenanceproduk.delete');       

         Route::get('/{maintenanceproduk}/print', [MaintenanceController::class, 'print'])->name('maintenanceproduk.print');                       
        
    });
});

