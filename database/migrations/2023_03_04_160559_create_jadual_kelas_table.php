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
        Schema::create('jadual_kelas', function (Blueprint $table) {
            $table->id();
            $table->integer('pusat_pengajian_id')->nullable();
            $table->integer('kelas_id')->nullable();
            $table->integer('kursus_id')->nullable();
            $table->integer('subjek_id')->nullable();
            $table->integer('hari')->nullable();
            $table->string('masa_mula')->nullable();
            $table->string('masa_tamat')->nullable();
            $table->integer('pensyarah_id')->nullable();
            $table->integer('bilik_id')->nullable();
            $table->integer('sort')->nullable();
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
        Schema::dropIfExists('jadual_kelas');
    }
};
