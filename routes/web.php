<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Role;
use App\Http\Controllers\HomeController;
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
use App\Http\Controllers\Master\ProductGroupController;
use App\Http\Controllers\Master\KategoriPesananController;
use App\Http\Controllers\Master\ProductCategoryController;
use App\Http\Controllers\Permissions\PermissionController;
use App\Http\Controllers\Profile\UpdatePasswordController;
use App\Http\Controllers\Master\CustomerCategoryController;
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
use App\Http\Controllers\Permissions\AssignPermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('auth', 'verified')->group(function () {
    // Route::get('/', function () {
    //     return view('home');
    // });
    Route::get('/', [HomeController::class, 'index']);
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
    });


    Route::prefix('penerimaanbarang')->group(function () {
        Route::get('', [PenerimaanBarangController::class, 'index'])->name('penerimaanbarang.index');
        Route::get('{pesananpembelian}/create', [PenerimaanBarangController::class, 'create'])->name('penerimaanbarang.create');
        Route::post('{pesananpembelian}/create', [PenerimaanBarangController::class, 'store']);

        Route::get('{penerimaanbarang}/edit', [PenerimaanBarangController::class, 'edit'])->name('penerimaanbarang.edit');
        Route::put('{penerimaanbarang}/edit', [PenerimaanBarangController::class, 'update'])->name('penerimaanbarang.update');
        Route::get('{penerimaanbarang}/show', [PenerimaanBarangController::class, 'show'])->name('penerimaanbarang.show');


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

        Route::delete('delete_detail', [FakturPembelianController::class, 'destroy_detail'])->name('fakturpembelian.destroy_detail');

        Route::get('listpb', [FakturPembelianController::class, 'listpb'])->name('fakturpembelian.listpb');
    });
});

Route::middleware('has.role')->prefix('penjualan')->group(function () {
    Route::prefix('pesananpenjualan')->group(function () {
        Route::get('', [PesananPenjualanController::class, 'index'])->name('pesananpenjualan.index');
        Route::get('create', [PesananPenjualanController::class, 'create'])->name('pesananpenjualan.create');
        Route::post('create', [PesananPenjualanController::class, 'store']);
        Route::get('{pesananpenjualan}/edit', [PesananPenjualanController::class, 'edit'])->name('pesananpenjualan.edit');
        Route::put('{pesananpenjualan}/edit', [PesananPenjualanController::class, 'update'])->name('pesananpenjualan.update');
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
    });

    Route::prefix('pengirimanbarang')->group(function () {
        Route::get('', [PengirimanBarangController::class, 'index'])->name('pengirimanbarang.index');
        Route::get('{pesananpenjualan}/create', [PengirimanBarangController::class, 'create'])->name('pengirimanbarang.create');
        Route::post('{pesananpenjualan}/create', [PengirimanBarangController::class, 'store']);

        Route::get('{pengirimanbarang}/edit', [PengirimanBarangController::class, 'edit'])->name('pengirimanbarang.edit');
        Route::put('{pengirimanbarang}/edit', [PengirimanBarangController::class, 'update'])->name('pengirimanbarang.update');
        Route::get('{pengirimanbarang}/show', [PengirimanBarangController::class, 'show'])->name('pengirimanbarang.show');

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
    });


    Route::prefix('fakturpenjualan')->group(function () {
        Route::get('', [FakturPenjualanController::class, 'index'])->name('fakturpenjualan.index');
        Route::get('{pengirimanbarang}/create', [FakturPenjualanController::class, 'create'])->name('fakturpenjualan.create');
        Route::post('{pengirimanbarang}/create', [FakturPenjualanController::class, 'store']);
        Route::get('{fakturpenjualan}/show', [FakturPenjualanController::class, 'show'])->name('fakturpenjualan.show');

        Route::post('delete', [FakturPenjualanController::class, 'delete'])->name('fakturpenjualan.delete');
        Route::delete('delete', [FakturPenjualanController::class, 'destroy'])->name('fakturpenjualan.destroy');
        Route::get('caribarang', [FakturPenjualanController::class, 'caribarang'])->name('fakturpenjualan.caribarang');
        Route::post('setbarang', [FakturPenjualanController::class, 'setbarang'])->name('fakturpenjualan.setbarang');
        Route::post('editbarang', [FakturPenjualanController::class, 'editbarang'])->name('fakturpenjualan.editbarang');
        Route::post('updatebarang', [FakturPenjualanController::class, 'updatebarang'])->name('fakturpenjualan.updatebarang');

        Route::post('inputtempsj', [FakturPenjualanController::class, 'inputtemppb'])->name('fakturpenjualan.inputtempsj');
        Route::post('loadtempsj', [FakturPenjualanController::class, 'loadtemppb'])->name('fakturpenjualan.loadtempsj');

        Route::delete('delete_detail', [FakturPenjualanController::class, 'destroy_detail'])->name('fakturpenjualan.destroy_detail');

        Route::get('listsj', [FakturPenjualanController::class, 'listsj'])->name('fakturpenjualan.listsj');
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
        Route::get('', [PembayaranPiutangController::class, 'index'])->name('pembayaranpiutang.index');
        Route::get('listpiutang', [PembayaranPiutangController::class, 'listpiutang'])->name('pembayaranpiutang.listpiutang');
        Route::get('{piutang}/create', [PembayaranPiutangController::class, 'create'])->name('pembayaranpiutang.create');
        Route::get('{piutang}/create', [PembayaranPiutangController::class, 'create'])->name('pembayaranpiutang.create');
        Route::post('{piutang}/create', [PembayaranPiutangController::class, 'store']);
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
    });
});
