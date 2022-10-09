<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonversiDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konversi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konversi_id')->constrained('konversis');
            $table->foreignId('product_id')->constrained('products');
            $table->date('tanggal');
            $table->bigInteger('qty');
            $table->string('satuan');
            $table->string('lot')->nullable();
            $table->date('exp_date')->nullable();
            $table->foreignId('user_id')->constrained('users');       
            $table->text('keterangan')->nullable();

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

            $table->softDeletes();
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
        Schema::dropIfExists('konversi_details');
    }
}
