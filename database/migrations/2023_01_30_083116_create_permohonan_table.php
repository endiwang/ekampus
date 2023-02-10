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
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('no_rujukan');
            $table->integer('kursus_id');
            $table->integer('sesi_id');
            $table->integer('pusat_pengajian_id')->nullable()->default(1);
            $table->string('nama')->nullable();
            $table->string('nama_jawi')->nullable();
            $table->string('email')->nullable();
            $table->string('no_ic')->nullable();
            $table->date('tarikh_lahir')->nullable();
            $table->longText('alamat_tetap')->nullable();
            $table->string('poskod')->nullable();
            $table->string('bandar')->nullable();
            $table->integer('daerah_id')->nullable();
            $table->integer('negeri_id')->nullable();
            $table->integer('dun_id')->nullable();
            $table->integer('parlimen_id')->nullable();
            $table->string('no_tel')->nullable();
            $table->char('jantina')->nullable();
            $table->integer('negeri_kelahiran_id')->nullable();
            $table->longText('alamat_surat')->nullable();
            $table->integer('keturunan_id')->nullable();
            $table->integer('bumiputra')->nullable();
            $table->integer('mualaf')->nullable();
            $table->integer('warganegara')->nullable();
            $table->integer('temuduga')->nullable();
            $table->integer('perakuan')->nullable()->default(0);

            $table->integer('is_submitted')->nullable()->default(0);
            $table->dateTime('submitted_date')->nullable();
            $table->integer('is_selected')->nullable()->default(0);
            $table->dateTime('selected_date')->nullable();
            $table->integer('selected_by')->nullable();
            $table->integer('is_interview')->nullable()->default(0);
            $table->integer('is_interview_surat')->nullable()->default(0);
            $table->date('interview_date')->nullable();
            $table->integer('interview_by')->nullable();
            $table->integer('is_tawaran')->nullable()->default(0);
            $table->integer('is_tawaran_surat')->nullable()->default(0);
            $table->date('tawaran_date')->nullable();
            $table->integer('tawaran_by')->nullable();
            $table->integer('is_terima')->nullable()->default(0);
            $table->dateTime('terima_date')->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(0);
            $table->string('deleted_by')->nullable();
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
        Schema::dropIfExists('permohonan');
    }
};
