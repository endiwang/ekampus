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
        Schema::create('permohonan_kesihatan', function (Blueprint $table) {
            $table->id();
            $table->integer('alergi')->default(0)->nullable();
            $table->integer('jantung')->default(0)->nullable();
            $table->integer('tibi')->default(0)->nullable();
            $table->integer('asma')->default(0)->nullable();
            $table->integer('migrain')->default(0)->nullable();
            $table->integer('buah_pinggan')->default(0)->nullable();
            $table->integer('kencing_manis')->default(0)->nullable();
            $table->integer('darah_tinggi')->default(0)->nullable();
            $table->integer('sakit_metal')->default(0)->nullable();
            $table->integer('anxiety')->default(0)->nullable();
            $table->integer('masuk_wad')->default(0)->nullable();
            $table->integer('pembedahan')->default(0)->nullable();
            $table->integer('psikiatri')->default(0)->nullable();
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
        Schema::dropIfExists('permohonan_kesihatan');
    }
};
