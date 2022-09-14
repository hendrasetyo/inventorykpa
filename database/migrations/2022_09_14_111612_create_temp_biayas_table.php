<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempBiayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_biayas', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->nullable();
            $table->double('rupiah')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('pengiriman_barang_id')->constrained('pengiriman_barangs');
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
        Schema::dropIfExists('temp_biayas');
    }
}
