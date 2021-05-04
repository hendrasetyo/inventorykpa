<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengirimanbarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_sjs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
        });

        Schema::create('pengiriman_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->date('tanggal');
            $table->unsignedBigInteger('pesanan_penjualan_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('status_sj_id');
            $table->double('status_exp')->nullable();
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

            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('cascade');

            $table->foreign('status_sj_id')
                ->references('id')->on('status_sjs')
                ->onDelete('cascade');

            $table->foreign('pesanan_penjualan_id')
                ->references('id')->on('pesanan_penjualans')
                ->onDelete('cascade');
        });

        Schema::create('pengiriman_barang_details', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('pengiriman_barang_id');
            $table->unsignedBigInteger('pesanan_penjualan_id');
            $table->unsignedBigInteger('pesanan_penjualan_detail_id');
            $table->unsignedBigInteger('product_id');
            $table->double('status_exp')->nullable();
            $table->double('qty');
            $table->double('qty_sisa');
            $table->double('qty_pesanan');
            $table->string('satuan');
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

            $table->foreign('pesanan_penjualan_detail_id')
                ->references('id')->on('pesanan_penjualan_details')
                ->onDelete('cascade');
            $table->foreign('pengiriman_barang_id')
                ->references('id')->on('pengiriman_barangs')
                ->onDelete('cascade');
        });

        Schema::create('temp_sjs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_penjualan_detail_id');
            $table->unsignedBigInteger('product_id');
            $table->double('qty');
            $table->double('qty_sisa');
            $table->double('qty_pesanan');
            $table->string('satuan');
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengiriman_barangs');
        Schema::dropIfExists('pengiriman_barang_details');
        Schema::dropIfExists('temp_sjs');
        Schema::dropIfExists('status_sjs');
    }
}
