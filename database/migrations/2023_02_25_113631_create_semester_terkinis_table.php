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
        Schema::create('semester_terkini', function (Blueprint $table) {
            $table->id();
            $table->integer('pusat_pengajian_id')->nullable();
            $table->integer('kursus_id')->nullable();
            $table->integer('semester_id')->nullable();
            $table->integer('semester_no')->nullable();
            $table->string('semester_name')->nullable();
            $table->string('sesi_masuk')->nullable();
            $table->string('sesi_pengajian')->nullable();
            $table->string('sesi')->nullable();
            $table->integer('status_semester')->default(0);
            $table->integer('status_keputusan')->default(0);
            $table->integer('status_keputusan_2')->default(0);
            $table->integer('status_keputusan_3')->default(0);
            $table->integer('status_keputusan_4')->default(0);
            $table->integer('status_keputusan_5')->default(0);
            $table->integer('status_keputusan_6')->default(0);
            $table->integer('status_keputusan_7')->default(0);
            $table->integer('status_keputusan_8')->default(0);
            $table->integer('status_keputusan_ulangan')->default(0);
            $table->date('tarikh_mula_permohonan')->nullable();
            $table->date('tarikh_akhir_permohonan')->nullable();
            $table->date('tarikh_daftar')->nullable();
            $table->date('tarikh_mula_daftar_kursus')->nullable();
            $table->date('tarikh_akhir_daftar_kursus')->nullable();
            $table->date('tarikh_mula_kursus')->nullable();
            $table->date('tarikh_akhir_kursus')->nullable();
            $table->date('tarikh_mula_kuliah')->nullable();
            $table->date('tarikh_akhir_kuliah')->nullable();
            $table->date('tarikh_mula_peperiksaan')->nullable();
            $table->date('tarikh_akhir_peperiksaan')->nullable();
            $table->date('tarikh_keputusan_peperiksaan')->nullable();
            $table->timestamps();
            $table->integer('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semester_terkini');
    }
};
