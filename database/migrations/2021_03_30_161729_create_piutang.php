<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiutang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piutangs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('pesanan_penjualan_id');
            $table->unsignedBigInteger('pengiriman_barang_id');
            $table->unsignedBigInteger('faktur_penjualan_id');
            $table->double('dpp');
            $table->double('ppn');
            $table->double('total');
            $table->double('dibayar');
            $table->double('status');
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('cascade');

            $table->foreign('pesanan_penjualan_id')
                ->references('id')->on('pesanan_penjualans')
                ->onDelete('cascade');

            $table->foreign('pengiriman_barang_id')
                ->references('id')->on('pengiriman_barangs')
                ->onDelete('cascade');
            $table->foreign('faktur_penjualan_id')
                ->references('id')->on('faktur_penjualans')
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
        Schema::dropIfExists('piutangs');
    }
}
