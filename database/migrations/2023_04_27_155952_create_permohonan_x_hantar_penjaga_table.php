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
        Schema::create('permohonan_x_hantar_penjaga', function (Blueprint $table) {
            $table->id();
            $table->integer('permohonan_x_hantar_id');
            $table->string('status_bapa')->nullable();
            $table->string('nama_bapa')->nullable();
            $table->string('ic_no_bapa')->nullable();
            $table->mediumText('alamat_bapa')->nullable();
            $table->string('poskod_bapa')->nullable();
            $table->string('no_telefon_bapa')->nullable();
            $table->string('status_pekerjaan_bapa')->nullable();
            $table->string('jenis_pekerjaan_bapa')->nullable();
            $table->string('pendapatan_bapa')->nullable();

            $table->string('status_ibu')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('ic_no_ibu')->nullable();
            $table->mediumText('alamat_ibu')->nullable();
            $table->string('poskod_ibu')->nullable();
            $table->string('no_telefon_ibu')->nullable();
            $table->string('status_pekerjaan_ibu')->nullable();
            $table->string('jenis_pekerjaan_ibu')->nullable();
            $table->string('pendapatan_ibu')->nullable();
            $table->string('pemohon_tinggal_bersama')->nullable();

            $table->string('nama_penjaga')->nullable();
            $table->string('ic_no_penjaga')->nullable();
            $table->mediumText('alamat_penjaga')->nullable();
            $table->string('poskod_penjaga')->nullable();
            $table->string('no_telefon_penjaga')->nullable();
            $table->string('status_pekerjaan_penjaga')->nullable();
            $table->string('jenis_pekerjaan_penjaga')->nullable();
            $table->string('pendapatan_penjaga')->nullable();
            $table->string('pertalian_penjaga')->nullable();
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
        Schema::dropIfExists('permohonan_x_hantar_penjaga');
    }
};
