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
        Schema::create('keluar_masuk', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('pelajar_id');
            $table->date('tarikh_keluar')->nullable();
            $table->time('waktu_keluar')->nullable();
            $table->date('tarikh_masuk')->nullable();
            $table->time('waktu_masuk')->nullable();
            $table->integer('permohonan_keluar_masuk_id')->nullable();
            $table->integer('status')->default(0)->comment('0 - Keluar, 1 - Masuk, 2 lewat,  3 lewat dengan alasan');
            $table->longText('alasan_lewat')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('keluar_masuk');
    }
};
