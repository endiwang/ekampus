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
        Schema::create('siasatan_aduan_salahlaku_pelajar', function (Blueprint $table) {
            $table->id();
            $table->integer('aduan_salahlaku_pelajar_id')->nullable();
            $table->date('tarikh_mula_siasatan')->nullable();
            $table->time('masa_mula_siasatan')->nullable();
            $table->date('tarikh_akhir_siasatan')->nullable();
            $table->time('masa_akhir_siasatan')->nullable();
            $table->string('tempat_siasatan')->nullable();
            $table->string('kategori_kesalahan')->nullable()->comment('R - Ringan, B - Berat');
            $table->string('jenis_kesalahan')->nullable()->comment('kolej_kediaman - KK, umum - U');
            $table->longText('keterangan_tertuduh')->nullable();
            $table->string('keputusan_siasatan')->nullable()->comment('Bersalah - S, Tidak Bersalah - TS');
            $table->string('dokument_siasatan')->nullable();
            $table->string('dokument_siasatan_2')->nullable();
            $table->string('dokument_siasatan_3')->nullable();
            $table->string('update_by')->nullable();
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
        Schema::dropIfExists('siasatan_aduan_salahlaku_pelajar');
    }
};
