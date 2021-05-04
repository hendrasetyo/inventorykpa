<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanBarangs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_pbs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
        });

        Schema::create('penerimaan_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->date('tanggal');
            $table->unsignedBigInteger('pesanan_pembelian_id');
            $table->string('sj_supplier')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('status_pb_id');
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

            $table->foreign('supplier_id')
                ->references('id')->on('suppliers')
                ->onDelete('cascade');

            $table->foreign('status_pb_id')
                ->references('id')->on('status_pbs')
                ->onDelete('cascade');

            $table->foreign('pesanan_pembelian_id')
                ->references('id')->on('pesanan_pembelians')
                ->onDelete('cascade');
        });

        Schema::create('penerimaan_barang_details', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('pesanan_pembelian_id');
            $table->unsignedBigInteger('pesanan_pembelian_detail_id');
            $table->unsignedBigInteger('product_id');
            $table->double('qty');
            $table->double('qty_sisa');
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

            $table->foreign('pesanan_pembelian_id')
                ->references('id')->on('pesanan_pembelians')
                ->onDelete('cascade');

            $table->foreign('pesanan_pembelian_detail_id')
                ->references('id')->on('pesanan_pembelian_details')
                ->onDelete('cascade');
        });

        Schema::create('temp_pbs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_pembelian_detail_id');
            $table->unsignedBigInteger('product_id');
            $table->double('qty');
            $table->double('qty_sisa');
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
        Schema::dropIfExists('penerimaan_barangs');
        Schema::dropIfExists('penerimaan_barang_details');
        Schema::dropIfExists('penerimaan_barangs');
    }
}
