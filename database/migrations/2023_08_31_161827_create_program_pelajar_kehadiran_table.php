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
        Schema::create('program_pelajar_kehadiran', function (Blueprint $table) {
            $table->id();
            $table->integer('program_id')->nullable();
            $table->integer('pelajar_id')->nullable();
            $table->integer('sesi_1')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_2')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_3')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_4')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_5')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_6')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_7')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_8')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_9')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_10')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_11')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_12')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_13')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_14')->nullable()->comment('0 tak hadir, 1 hadir');
            $table->integer('sesi_15')->nullable()->comment('0 tak hadir, 1 hadir');
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
        Schema::dropIfExists('program_pelajar_kehadiran');
    }
};
