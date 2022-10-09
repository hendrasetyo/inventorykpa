<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonversisTable extends Migration
{
    /**
 * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konversis', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->foreignId('product_id')->constrained('products');
            $table->date('tanggal');                        
            $table->bigInteger('qty');
            $table->date('exp_date');
            $table->text('keterangan')->nullable();
            $table->foreignId('expdate_id')->nullable()->constrained('stok_exps');
            $table->foreignId('user_id')->constrained('users');   

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

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('konversis');
    }
}
