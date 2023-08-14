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
        Schema::create('tetapan_peperiksaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->integer('pusat_pengajian_id')->nullable();
            $table->integer('kursus_id')->nullable();
            $table->integer('sesi_id')->nullable();
            $table->integer('semester_id')->nullable();
            $table->integer('syukbah_id')->nullable();
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
        Schema::dropIfExists('tetapan_peperiksaan');
    }
};
