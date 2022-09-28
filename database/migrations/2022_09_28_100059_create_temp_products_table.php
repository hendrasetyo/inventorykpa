<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempProductsTable extends Migration
{
   
    public function up()
    {
        Schema::create('temp_products', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->nullable();
            $table->unsignedBigInteger('productgroup_id')->nullable();
            $table->string('jenis')->nullable();
            $table->unsignedBigInteger('merk_id')->nullable();
            $table->string('tipe')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('kemasan')->nullable();
            $table->string('satuan')->nullable();
            $table->string('katalog')->nullable();
            $table->string('asal_negara')->nullable();
            $table->string('pabrikan')->nullable();
            $table->string('no_ijinedar')->nullable();
            $table->date('exp_ijinedar')->nullable();
            $table->unsignedBigInteger('productcategory_id')->nullable();
            $table->unsignedBigInteger('productsubcategory_id')->nullable();
            $table->double('hargajual', 14, 2)->nullable();
            $table->double('hargabeli', 14, 2)->nullable();
            $table->double('hpp', 14, 2)->nullable();
            $table->double('diskon_persen', 14, 2)->nullable();
            $table->double('diskon_rp', 14, 2)->nullable();
            $table->string('keterangan')->nullable();
            $table->string('status')->nullable();
            $table->boolean('status_exp')->nullable();
            $table->integer('stok')->nullable();
            $table->integer('stok_canvassing')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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

            $table->foreign('merk_id')
                ->references('id')->on('merks')
                ->onDelete('cascade');

            $table->foreign('productcategory_id')
                ->references('id')->on('productcategories')
                ->onDelete('cascade');

            $table->foreign('productsubcategory_id')
                ->references('id')->on('productsubcategories')
                ->onDelete('cascade');

            $table->foreign('productgroup_id')
                ->references('id')->on('productgroups')
                ->onDelete('cascade');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('temp_products');
    }
}
