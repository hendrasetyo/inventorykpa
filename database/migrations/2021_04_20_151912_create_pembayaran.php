<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor')->nullable();
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
        });

        Schema::create('pembayaran_hutangs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('faktur_pembelian_id');
            $table->unsignedBigInteger('hutang_id');
            $table->unsignedBigInteger('bank_id');
            $table->double('nominal')->nullable();
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
            $table->foreign('faktur_pembelian_id')
                ->references('id')->on('faktur_pembelians')
                ->onDelete('cascade');
            $table->foreign('hutang_id')
                ->references('id')->on('hutangs')
                ->onDelete('cascade');
            $table->foreign('bank_id')
                ->references('id')->on('banks')
                ->onDelete('cascade');
        });

        Schema::create('pembayaran_piutangs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('faktur_penjualan_id');
            $table->unsignedBigInteger('piutang_id');
            $table->unsignedBigInteger('bank_id');
            $table->double('nominal')->nullable();
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
            $table->foreign('faktur_penjualan_id')
                ->references('id')->on('faktur_penjualans')
                ->onDelete('cascade');
            $table->foreign('piutang_id')
                ->references('id')->on('piutangs')
                ->onDelete('cascade');
            $table->foreign('bank_id')
                ->references('id')->on('banks')
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
        Schema::dropIfExists('banks');
        Schema::dropIfExists('pembayaran_hutangs');
        Schema::dropIfExists('pembayaran_piutangs');
    }
}
