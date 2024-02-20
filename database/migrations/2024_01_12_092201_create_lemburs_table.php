<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLembursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('lembur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawan');
            $table->foreignId('penanggungjawab_id')->constrained('karyawan');
            $table->string('tugas')->nullable();            
            $table->integer('jumlah_jam');
            $table->date('tanggal');
            $table->double('nominal_gaji');
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
        Schema::dropIfExists('lemburs');
    }
}
