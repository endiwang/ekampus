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
        Schema::create('tetapan_permohonan_pelajar', function (Blueprint $table) {
            $table->id();
            $table->integer('kursus_id')->nullable()->default(0);
            $table->string('sesi_id')->nullable();
            $table->integer('pusat_pengajian_id')->nullable()->default(1);
            $table->tinyInteger('status_ujian')->default(0)->comment('0 for close');
            $table->tinyInteger('status')->nullable()->default(0);
            $table->date('mula_permohonan')->nullable();
            $table->date('tutup_permohonan')->nullable();
            $table->date('tutup_pendaftaran')->nullable();
            $table->date('mula_semakan_temuduga')->nullable();
            $table->date('tutup_semakan_temuduga')->nullable();
            $table->string('tajuk_semakan_temuduga')->nullable();
            $table->text('maklumat_semakan_temuduga')->nullable();
            $table->date('mula_semakan_tawaran')->nullable();
            $table->date('tutup_semakan_tawaran')->nullable();
            $table->date('tutup_rayuan')->nullable();
            $table->string('tajuk_semakan_rayuan')->nullable();
            $table->date('mula_semakan_rayuan')->nullable();
            $table->date('tutup_semakan_rayuan')->nullable();
            $table->string('tajuk_semakan_tawaran')->nullable();
            $table->text('maklumat_semakan_tawaran')->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(0);
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('tetapan_permohonan_pelajar');
    }
};
