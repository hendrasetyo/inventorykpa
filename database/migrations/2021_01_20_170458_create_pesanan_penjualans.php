<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananPenjualans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_sos', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
        });

        Schema::create('pesanan_penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->date('tanggal');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('kategoripesanan_id');
            $table->unsignedBigInteger('komoditas_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('status_so_id');
            $table->string('pemesan');
            $table->string('ppk');
            $table->string('tahun_anggaran');
            $table->string('sumber_dana');
            $table->string('nama_paket');
            $table->string('id_paket');
            $table->string('no_so')->nullable();
            $table->double('top')->nullable();
            $table->string('keterangan')->nullable();
            $table->double('diskon_persen')->nullable();
            $table->double('diskon_rupiah')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('total_diskon_detail')->nullable();
            $table->double('total_diskon_header')->nullable();
            $table->double('total')->nullable();
            $table->double('ppn')->nullable();
            $table->double('ongkir')->nullable();
            $table->double('grandtotal')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('updated_by')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('deleted_by')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('cascade');

            $table->foreign('kategoripesanan_id')
                ->references('id')->on('kategoripesanans')
                ->onDelete('cascade');

            $table->foreign('komoditas_id')
                ->references('id')->on('komoditas')
                ->onDelete('cascade');

            $table->foreign('status_so_id')
                ->references('id')->on('status_sos')
                ->onDelete('cascade');
        });

        Schema::create('temp_sos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->double('qty');
            $table->string('satuan');
            $table->double('hargajual')->nullable();
            $table->double('diskon_persen')->nullable();
            $table->double('diskon_rp')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('total_diskon')->nullable();
            $table->double('total')->nullable();
            $table->double('ongkir')->nullable();
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::create('pesanan_penjualan_details', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('pesanan_penjualan_id');
            $table->unsignedBigInteger('product_id');
            $table->double('qty');
            $table->double('qty_sisa');
            $table->string('satuan');
            $table->double('hargajual')->nullable();
            $table->double('diskon_persen')->nullable();
            $table->double('diskon_rp')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('total_diskon')->nullable();
            $table->double('total')->nullable();
            $table->double('ongkir')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('updated_by')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('deleted_by')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

            $table->foreign('pesanan_penjualan_id')
                ->references('id')->on('pesanan_penjualans')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanan_penjualans');
    }
}
