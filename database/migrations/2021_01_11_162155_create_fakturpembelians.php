<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakturpembelians extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_fakturpos', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
        });

        Schema::create('faktur_pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->date('tanggal');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('pesanan_pembelian_id');
            $table->unsignedBigInteger('penerimaan_barang_id');
            $table->unsignedBigInteger('status_fakturpo_id');
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

            $table->foreign('supplier_id')
                ->references('id')->on('suppliers')
                ->onDelete('cascade');

            $table->foreign('pesanan_pembelian_id')
                ->references('id')->on('pesanan_pembelians')
                ->onDelete('cascade');

            $table->foreign('penerimaan_barang_id')
                ->references('id')->on('penerimaan_barangs')
                ->onDelete('cascade');

            $table->foreign('status_fakturpo_id')
                ->references('id')->on('status_fakturpos')
                ->onDelete('cascade');
        });



        Schema::create('faktur_pembelian_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faktur_pembelian_id');
            $table->unsignedBigInteger('penerimaan_barang_detail_id');
            $table->unsignedBigInteger('product_id');
            $table->double('qty');
            $table->string('satuan');
            $table->double('hargabeli')->nullable();
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

            $table->foreign('penerimaan_barang_detail_id')
                ->references('id')->on('penerimaan_barangs')
                ->onDelete('cascade');

            $table->foreign('faktur_pembelian_id')
                ->references('id')->on('faktur_pembelians')
                ->onDelete('cascade');
        });

        Schema::create('temp_fakturpos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('penerimaan_barang_detail_id');
            $table->double('qty');
            $table->string('satuan');
            $table->double('hargabeli')->nullable();
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
        Schema::dropIfExists('status_fakturpos');
        Schema::dropIfExists('faktur_pembelians');
        Schema::dropIfExists('faktur_pembelian_details');
        Schema::dropIfExists('temp_fakturpos');
    }
}
