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
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->string('nama_artikel')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('document_name')->nullable();
            $table->string('upload_document')->nullable();
            $table->datetime('tarikh_dihantar')->nullable();
            $table->integer('penyumbang')->nullable();
            $table->integer('editor')->nullable();
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
        Schema::dropIfExists('artikel');
    }
};
