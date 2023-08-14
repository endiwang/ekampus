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
        Schema::create('tetapan_keluar_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tetapan');
            $table->integer('hari_id');
            $table->time('waktu_keluar')->nullable();
            $table->time('waktu_masuk')->nullable();
            $table->string('jantina')->nullable();
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
        Schema::dropIfExists('tetapan_keluar_masuk');
    }
};
