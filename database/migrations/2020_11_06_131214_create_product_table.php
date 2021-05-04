<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merks', function (Blueprint $table) {
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

        Schema::create('satuans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('productcategories', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
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

        Schema::create('productsubcategories', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('productcategory_id');
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

            $table->foreign('productcategory_id')
                ->references('id')->on('productcategories')
                ->onDelete('cascade');
        });

        Schema::create('productgroups', function (Blueprint $table) {
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

        Schema::create('products', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merks');
        Schema::dropIfExists('satuans');
        Schema::dropIfExists('productcategories');
        Schema::dropIfExists('productsubcategories');
        Schema::dropIfExists('merks');
        Schema::dropIfExists('productgroups');
        Schema::dropIfExists('product');
    }
}
