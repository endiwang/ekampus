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
        Schema::create('permohonan_pelekat_kenderaan', function (Blueprint $table) {
            $table->id();
            $table->string('no_permohonan')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('jenis_pemohon')->nullable()->comment('1-pelajar 2-kakitangan 3-vendor');
            $table->string('document_name')->nullable();
            $table->string('upload_document')->nullable();
            $table->integer('jenis_kenderaan')->nullable()->comment('1-motokar 2-motorsikal');
            $table->string('jenama')->nullable();
            $table->string('no_plate')->nullable();
            $table->date('tarikh_tamat_cukai')->nullable();
            $table->string('document_name_geran')->nullable()->comment('geran pic');
            $table->string('upload_document_geran')->nullable();
            $table->string('document_name_surat_kuasa')->nullable()->comment('surat kuasa pic');
            $table->string('upload_document_surat_kuasa')->nullable();
            $table->string('document_name_lesen')->nullable()->comment('license pic');
            $table->string('upload_document_lesen')->nullable();
            $table->date('tarikh_tamat_lesen');
            $table->integer('status')->nullable()->comment('1-baru 2-proses 3-lulus 4-gagal');
            $table->integer('approved_by')->nullable();
            $table->date('tarikh_approved')->nullable();
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
        Schema::dropIfExists('permohonan_pelekat_kenderaan');
    }
};
