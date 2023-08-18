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
        Schema::create('muadalah', function (Blueprint $table) {
            $table->id();
            $table->integer('jenis_dokumen')->nullable()->comment('jenis dokumen');
            $table->string('nama')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('document_name')->nullable();
            $table->string('upload_document')->nullable();
            $table->integer('keadaan_dokumen')->nullable();
            $table->integer('upload_by')->nullable();
            $table->integer('status')->nullable();
            $table->datetime('tarikh_upload')->nullable();
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
        Schema::dropIfExists('muadalah');
    }
};
