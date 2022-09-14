<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanvassingPengembalianDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canvassing_pengembalian_details', function (Blueprint $table) {

            $table->id();
            $table->foreignId('canvassing_kembali_id')->constrained('canvassing_pengembalians');
            $table->foreignId('product_id')->constrained('products');
            $table->date('tanggal');
            $table->double('qty');
            $table->double('qty_sisa');
            $table->double('qty_kirim');
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
        Schema::dropIfExists('canvassing_pengembalian_details');
    }
}
