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
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('no_rujukan');
            $table->integer('kursus_id');
            $table->string('sesi_id');
            $table->integer('pusat_pengajian_id')->nullable()->default(1);
            $table->string('nama')->nullable();
            $table->string('nama_jawi')->nullable();
            $table->string('email')->nullable();
            $table->string('no_ic')->nullable();
            $table->date('tarikh_lahir')->nullable();
            $table->longText('alamat_tetap')->nullable();
            $table->string('poskod')->nullable();
            $table->string('bandar')->nullable();
            $table->integer('daerah_id')->nullable();
            $table->integer('negeri_id')->nullable();
            $table->integer('dun_id')->nullable();
            $table->integer('parlimen_id')->nullable();
            $table->string('no_tel')->nullable();
            $table->char('jantina')->nullable();
            $table->integer('negeri_kelahiran_id')->nullable();
            $table->longText('alamat_surat')->nullable();
            $table->integer('keturunan_id')->nullable();
            $table->integer('bumiputra')->nullable();
            $table->integer('mualaf')->nullable();
            $table->integer('warganegara')->nullable();
            $table->integer('temuduga')->nullable();
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
        Schema::dropIfExists('permohonan');
    }
};
