<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakturpenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_faktursos', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
        });

        Schema::create('faktur_penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->date('tanggal');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('pesanan_penjualan_id');
            $table->unsignedBigInteger('pengiriman_barang_id');
            $table->unsignedBigInteger('status_fakturso_id');
            $table->string('keterangan')->nullable();
            $table->double('diskon_rupiah')->nullable();
            $table->double('diskon_persen')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('total_diskon_detail')->nullable();
            $table->double('total_diskon_header')->nullable();
            $table->double('total')->nullable();
            $table->double('grandtotal')->nullable();
            $table->double('ppn')->nullable();
            $table->double('ongkir')->nullable();

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

            $table->foreign('pesanan_penjualan_id')
                ->references('id')->on('pesanan_penjualans')
                ->onDelete('cascade');

            $table->foreign('pengiriman_barang_id')
                ->references('id')->on('pengiriman_barangs')
                ->onDelete('cascade');

            $table->foreign('status_fakturso_id')
                ->references('id')->on('status_faktursos')
                ->onDelete('cascade');
        });



        Schema::create('faktur_penjualan_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faktur_penjualan_id');
            $table->unsignedBigInteger('pengiriman_barang_detail_id');
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

            $table->foreign('pengiriman_barang_detail_id')
                ->references('id')->on('pengiriman_barang_details')
                ->onDelete('cascade');

            $table->foreign('faktur_penjualan_id')
                ->references('id')->on('faktur_penjualans')
                ->onDelete('cascade');
        });

        Schema::create('temp_faktursos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('pengiriman_barang_detail_id');
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_faktursos');
        Schema::dropIfExists('faktur_penjualans');
        Schema::dropIfExists('faktur_penjualan_details');
        Schema::dropIfExists('temp_faktursos');
    }
}
