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
        Schema::create('maklumat_kursus_dan_latihan', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_kursus_dan_latihan')->nullable()->comment('FK for kursus dan latihan pensyarah');
            $table->string('nama')->nullable();
            $table->string('noic')->nullable();
            $table->string('maklumat_kursus')->nullable();
            $table->integer('tahun')->nullable();
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
        Schema::dropIfExists('maklumat_kursus_dan_latihan');
    }
};
