<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonan_x_hantar', function (Blueprint $table) {
            $table->id();
            $table->integer('pemohon_id')->nullable();
            $table->string('gambar')->nullable();
            $table->string('nama_pemohon')->nullable();
            $table->string('nama_jawi')->nullable();
            $table->string('no_kp')->nullable();
            $table->date('tarikh_lahir')->nullable();
            $table->mediumText('alamat_tetap')->nullable();
            $table->string('bandar_tetap')->nullable();
            $table->string('poskod_tetap')->nullable();
            $table->string('negeri_tetap')->nullable();
            $table->mediumText('alamat_surat')->nullable();
            $table->string('bandar_surat')->nullable();
            $table->string('poskod_surat')->nullable();
            $table->string('negeri_surat')->nullable();
            $table->string('no_telefon')->nullable();
            $table->string('jantina')->nullable();
            $table->string('negeri_kelahiran')->nullable();
            $table->string('keturunan')->nullable();
            $table->string('bumiputra')->nullable();
            $table->string('mualaf')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('kedaaan_fizikal')->nullable();
            $table->string('penyakit_kronik')->nullable();
            $table->string('rekod_kemasukan_wad')->nullable();
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
        Schema::dropIfExists('permohonan_x_hantar');
    }
};
