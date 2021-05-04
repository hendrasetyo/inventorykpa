<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('hp')->nullable();
            $table->string('nip')->nullable();
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
        });

        Schema::create('customer_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
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
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('alamat');
            $table->string('blok')->nullable();
            $table->string('nomor')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('tlp')->nullable();
            $table->string('email')->nullable();
            $table->string('npwp')->nullable();
            $table->unsignedBigInteger('sales_id')->nullable();
            $table->unsignedBigInteger('kategori_id');
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

            $table->foreign('kelurahan')
                ->references('id')
                ->on('indonesia_villages')
                ->onDelete('cascade');
            $table->foreign('kecamatan')
                ->references('id')
                ->on('indonesia_districts')
                ->onDelete('cascade');
            $table->foreign('kota')
                ->references('id')
                ->on('indonesia_cities')
                ->onDelete('cascade');
            $table->foreign('provinsi')
                ->references('id')
                ->on('indonesia_provinces')
                ->onDelete('cascade');
            $table->foreign('kategori_id')
                ->references('id')
                ->on('customer_categories');
            $table->foreign('sales_id')
                ->references('id')
                ->on('sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
        Schema::dropIfExists('customer_categories');
        Schema::dropIfExists('customers');
    }
}
