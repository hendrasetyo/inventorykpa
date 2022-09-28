<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempKonversiDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_konversi_dets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('temp_konversi_id')->constrained('temp_konversis');
            $table->foreignId('product_id')->constrained('products');
            $table->date('tanggal');
            $table->bigInteger('qty');
            $table->string('satuan');
            $table->string('lot')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('exp_date');
            $table->foreignId('user_id')->constrained('users');  
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
        Schema::dropIfExists('temp_konversi_dets');
    }
}
