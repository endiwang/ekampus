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
        Schema::create('permohonan_bawa_kenderaan', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id')->nullable();
            $table->string('no_rujukan')->nullable();
            $table->string('jenis_kenderaan')->nullable()->comment('K - Kereta, M - Motor');
            $table->string('jenama')->nullable();
            $table->string('model')->nullable();
            $table->string('warna')->nullable();
            $table->string('no_pendaftaran')->nullable();
            $table->date('tarikh_tamat_cukai')->nullable();
            $table->date('tarikh_tamat_lesen')->nullable();
            $table->text('sebab')->nullable();
            $table->string('gambar_hadapan')->nullable();
            $table->string('gambar_belakang')->nullable();
            $table->string('salinan_kad_matrik')->nullable();
            $table->string('salinan_lesen')->nullable();
            $table->string('salinan_geran')->nullable();
            $table->string('a')->nullable();
            $table->integer('status')->default(0)->comment('0 baru, 1 lulus, 2 tak lulus');
            $table->string('update_by')->nullable();
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
        Schema::dropIfExists('permohonan_bawa_kenderaan');
    }
};
