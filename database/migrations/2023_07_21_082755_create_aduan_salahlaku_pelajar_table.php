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
        Schema::create('aduan_salahlaku_pelajar', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment('pengadu');
            $table->date('tarikh_aduan')->nullable();
            $table->time('masa_aduan')->nullable();
            $table->date('tarikh_kes')->nullable();
            $table->time('masa_kes')->nullable();
            $table->string('tempat_kes')->nullable();
            $table->string('nama_saksi')->nullable();
            $table->string('nama_pelaku')->nullable();
            $table->string('no_ic_pelaku')->nullable();
            $table->string('no_matrik_pelaku')->nullable();
            $table->longText('aduan')->nullable();
            $table->string('jenis_kesalahan')->nullable()->comment('kolej_kediaman - KK, umum - U');
            $table->integer('kesalahan_kolej_kediaman_id')->nullable();
            $table->string('bukti')->nullable();
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
        Schema::dropIfExists('aduan_salahlaku_pelajar');
    }
};
