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
        Schema::create('penyelidikan', function (Blueprint $table) {
            $table->id();
            $table->integer('jenis_dokumen')->nullable()->comment('1=•	Dokumentasi Kod Amalan Akreditasi Pogram (COPPA) 2=•	Senarai Template Dokumen Audit');
            $table->string('nama')->nullable();
            $table->string('document_name')->nullable();
            $table->string('upload_document')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('keadaan_dokumen')->nullable()->comment('1=Dokumen baru,2=Dokumen Tambahan, 3=Dokumen Ganti 4=Dokumen Hapus');
            $table->datetime('tarikh_upload')->nullable()->comment('tarikh dan masa upload');
            $table->integer('upload_by')->nullable()->comment('diupload oleh');
            $table->integer('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penyelidikan');
    }
};
