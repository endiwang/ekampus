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
        Schema::create('pemarkahan_calon_sijil_tahfizs', function (Blueprint $table) {
            $table->id();
            $table->integer('permohonan_id');
            $table->integer('pelajar_id');
            $table->decimal('al_quran_syafawi', 10, 2)->nullable()->default(0.00);
            $table->decimal('al_quran_tahriri', 10, 2)->nullable()->default(0.0);
            $table->decimal('tajwid', 10, 2)->nullable()->default(0.0);
            $table->decimal('fiqh_ibadah', 10, 2)->nullable()->default(0.0);
            $table->decimal('akidah', 10, 2)->nullable()->default(0.0);
            $table->decimal('total_mark', 10, 2)->nullable()->nullable()->default(0.0);
            $table->integer('status_kelulusan')->nullable()->default(0);
            $table->string('keputusan_peperiksaan')->nullable();
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
        Schema::dropIfExists('pemarkahan_calon_sijil_tahfizs');
    }
};
