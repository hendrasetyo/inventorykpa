<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGrandtotalToPesananPembelians extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pesanan_pembelians', function (Blueprint $table) {
            $table->double('total_diskon_header')->after('total_diskon_detail');
            $table->double('diskon_persen')->after('keterangan');
            $table->double('diskon_rupiah')->after('keterangan');
            $table->double('grandtotal')->after('total');
            $table->double('ongkir')->after('total');
            $table->double('ppn')->after('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pesanan_pembelians', function (Blueprint $table) {
            //
        });
    }
}
