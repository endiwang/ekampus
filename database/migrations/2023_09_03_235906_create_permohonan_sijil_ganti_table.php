<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonan_sijil_ganti', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('pelajar_id')->nullable();
            $table->text('nama')->nullable();
            $table->string('no_matrik')->nullable();
            $table->string('no_ic')->nullable();
            $table->string('laporan_polis')->nullable();
            $table->string('salinan_sijil')->nullable();
            $table->string('kod_qr')->nullable();
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
        Schema::dropIfExists('permohonan_sijil_ganti');
    }
};