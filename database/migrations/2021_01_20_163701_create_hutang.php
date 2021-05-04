<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHutang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hutangs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('pesanan_pembelian_id');
            $table->unsignedBigInteger('penerimaan_barang_id');
            $table->unsignedBigInteger('faktur_pembelian_id');
            $table->double('dpp');
            $table->double('ppn');
            $table->double('total');
            $table->double('dibayar');
            $table->double('status');
            $table->timestamps();

            $table->foreign('supplier_id')
                ->references('id')->on('suppliers')
                ->onDelete('cascade');

            $table->foreign('pesanan_pembelian_id')
                ->references('id')->on('pesanan_pembelians')
                ->onDelete('cascade');

            $table->foreign('penerimaan_barang_id')
                ->references('id')->on('penerimaan_barangs')
                ->onDelete('cascade');
            $table->foreign('faktur_pembelian_id')
                ->references('id')->on('faktur_pembelians')
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
        Schema::dropIfExists('hutangs');
    }
}
