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
        Schema::create('jaminan_kualiti', function (Blueprint $table) {
            $table->id();
            $table->integer('lkp_kategori_maklumat')->nullable();
            $table->string('nama')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('jenis_dokumen')->nullable()->comment('baru,tambahan,ganti,hapus');
            $table->string('path')->nullable()->comment('path upload');
            $table->integer('user_id')->nullable()->commenet('user');
            $table->datetime('tarikh_upload')->nullable()->comment('tarikh upload');
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
        Schema::dropIfExists('jaminan_kualiti');
    }
};
