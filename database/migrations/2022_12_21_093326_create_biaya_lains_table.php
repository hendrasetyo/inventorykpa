<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiayaLainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biaya_lains', function (Blueprint $table) {
            $table->id();
            // $table->date('tanggal');
            $table->foreignId('jenisbiaya_id')->nullable()->constrained('jenis_biayas');
            $table->foreignId('fakturpenjualan_id')->nullable()->constrained('faktur_penjualans');
            $table->double('nominal');
            // $table->foreignId('bank_id')->nullable()->constrained('banks');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('biaya_lains');
    }
}
