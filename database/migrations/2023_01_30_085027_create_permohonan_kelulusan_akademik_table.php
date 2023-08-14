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
        Schema::create('permohonan_kelulusan_akademik', function (Blueprint $table) {
            $table->id();
            $table->integer('permohonan_id');
            $table->string('type');
            $table->string('tahun_pepriksaan');
            $table->string('nama_sijil');
            $table->string('nama_pepriksaan');
            $table->string('matapelajaran');
            $table->string('gred');
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
        Schema::dropIfExists('permohonan_kelulusan_akademik');
    }
};
