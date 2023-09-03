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
        Schema::create('tetapan_majlis_penyerahan_sijil_tahfizs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('siri')->nullable();
            $table->string('tahun')->nullable();
            $table->string('no_fail_surat')->nullable();
            $table->integer('pusat_pengajian_id')->nullable();
            $table->date('tarikh_surat_mula')->nullable();
            $table->date('tarikh_surat_akhir')->nullable();
            $table->date('tarikh_majlis_mula')->nullable();
            $table->date('tarikh_majlis_akhir')->nullable();
            $table->time('masa_majlis')->nullable();
            $table->integer('staff_id')->nullable();
            $table->date('tarikh_cetakan')->nullable();
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
        Schema::dropIfExists('tetapan_majlis_penyerahan_sijil_tahfizs');
    }
};
