<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nama');
            $table->foreignId('posisi_id')->constrained('posisi');
            $table->foreignId('jabatan_id')->constrained('jabatan');
            $table->string('email')->nullable();
            $table->string('hp')->nullable();
            $table->date('tanggal_masuk')->nullable();            
            $table->double('gaji_pokok')->nullable();
            $table->double('insentif')->nullable();        
            $table->text('alamat')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('rekening')->nullable();
            $table->string('bank')->nullable();
            $table->string('atas_nama')->nullable();
            $table->string('no_ktp')->nullable();
            $table->foreignId('statuskaryawan_id')->constrained('status_karyawan');
            $table->string('foto_ktp')->nullable();
            $table->string('foto_profil')->nullable();
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('karyawans');
    }
}
