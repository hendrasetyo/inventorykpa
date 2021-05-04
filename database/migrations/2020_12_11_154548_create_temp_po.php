<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempPo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_pos', function (Blueprint $table) {
            $table->id();
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
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::create('pesanan_pembelian_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_pembelian_id');
            $table->unsignedBigInteger('product_id');
            $table->double('qty');
            $table->string('satuan');
            $table->double('hargabeli')->nullable();
            $table->double('diskon_persen')->nullable();
            $table->double('diskon_rp')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('total_diskon_detail')->nullable();
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

            $table->foreign('pesanan_pembelian_id')
                ->references('id')->on('pesanan_pembelians')
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
        Schema::dropIfExists('temp_pos');
        Schema::dropIfExists('pesanan_pembelian_details');
    }
}
