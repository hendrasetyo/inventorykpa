<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempCanvasPengembaliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_canvas_pengembalians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canvassing_pesanan_id')->constrained('canvassing_pesanans');
            $table->foreignId('product_id')->constrained('products');
            $table->date('tanggal');
            $table->integer('qty');
            $table->integer('qty_sisa');
            $table->integer('qty_kirim');            
            $table->text('keterangan')->nullable();           
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
        Schema::dropIfExists('temp_canvas_pengembalians');
    }
}
