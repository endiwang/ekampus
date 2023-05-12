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
        Schema::create('permohonan_x_hantar_muat_naik_dokumen', function (Blueprint $table) {
            $table->id();
            $table->integer('permohonan_x_hantar_id');
            $table->string('jenis_dokumen');
            $table->string('nama_dokumen');
            $table->string('path');
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
        Schema::dropIfExists('permohonan_x_hantar_muat_naik_dokumen');
    }
};
