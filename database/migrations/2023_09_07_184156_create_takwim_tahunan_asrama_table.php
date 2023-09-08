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
        Schema::create('takwim_tahunan_asrama', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_pengajian')->nullable();
            $table->integer('blok_id')->nullable();
            $table->string('dokument')->nullable();
            $table->integer('status')->default(0)->comment('0 tidak aktif, 1 aktif');
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
        Schema::dropIfExists('takwim_tahunan_asrama');
    }
};
