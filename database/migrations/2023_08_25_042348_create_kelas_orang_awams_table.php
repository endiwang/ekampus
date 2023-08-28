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
        Schema::create('pi_kelas_orang_awam', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->dateTime('tarikh');
            $table->json('guru')->nullable();
            $table->string('token')->comment('Digunakan untuk pendaftaran orang awam.');
            $table->boolean('pendaftaran_dibuka')->default(false);
            $table->unsignedInteger('had_jumlah_pelajar')->default(10);
            $table->string('status')->nullable()->comment('Pendaftaran Dibuka, etc.');
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
        Schema::dropIfExists('pi_kelas_orang_awam');
    }
};
