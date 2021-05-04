<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQtyPesananToPenerimaanBarangDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penerimaan_barang_details', function (Blueprint $table) {
            $table->double('qty_pesanan')->after('qty_sisa');
        });
        Schema::table('temp_pbs', function (Blueprint $table) {
            $table->double('qty_pesanan')->after('qty_sisa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penerimaan_barang_details', function (Blueprint $table) {
            //
        });
    }
}
