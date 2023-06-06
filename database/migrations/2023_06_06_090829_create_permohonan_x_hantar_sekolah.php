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
        Schema::create('permohonan_x_hantar_sekolah', function (Blueprint $table) {
            $table->id();
            $table->integer('permohonan_x_hantar_id');
            $table->string('sekolah');
            $table->string('tahun');
            $table->string('kelulusan');
            $table->string('keputusan');
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
        Schema::dropIfExists('permohonan_x_hantar_sekolah');
    }
};
