<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanvassingPesananDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canvassing_pesanan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canvassing_pesanan_id')->constrained('canvassing_pesanans');
            $table->foreignId('product_id')->constrained('products');
            $table->date('tanggal');
            $table->double('qty');
            $table->double('qty_sisa');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('canvassing_pesanan_details');
    }
}
