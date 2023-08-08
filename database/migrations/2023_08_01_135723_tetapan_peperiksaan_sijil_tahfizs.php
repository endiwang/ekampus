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
        Schema::create('tetapan_peperiksaan_sijil_tahfizs', function (Blueprint $table) {
            $table->id();
            $table->string('siri')->nullable();
            $table->string('tahun')->nullable();
            $table->string('lokasi_peperiksaan')->nullable();
            $table->timestamp('tarikh_permohonan_dibuka')->nullable();
            $table->timestamp('tarikh_permohonan_ditutup')->nullable();
            $table->integer('status')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('is_deleted')->default(0);
            $table->integer('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('tetapan_peperiksaan_sijil_tahfizs');
    }
};
