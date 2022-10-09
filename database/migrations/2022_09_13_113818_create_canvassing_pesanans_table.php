<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanvassingPesanansTable extends Migration
{
  
    public function up()
    {
        Schema::create('canvassing_pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan');
            $table->string('kode');
            $table->date('tanggal');
            $table->integer('qty');
            $table->foreignId('customer_id')->constrained('customers');
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
    
    public function down()
    {
        Schema::dropIfExists('canvassing_pesanans');
    }
}
