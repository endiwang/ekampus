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
        Schema::create('permohonan_penjaga', function (Blueprint $table) {
            $table->id();
            $table->integer('permohonan_id');
            $table->integer('status_bapa')->nullable();
            $table->string('nama_bapa')->nullable();
            $table->string('no_ic_bapa')->nullable();
            $table->longText('alamat_surat_bapa')->nullable();
            $table->string('poskod_bapa')->nullable();
            $table->string('no_tel_bapa')->nullable();
            $table->integer('status_pekerjaan_bapa')->nullable();
            $table->integer('pendapatan_bapa')->nullable();
            $table->integer('status_ibu')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('no_ic_ibu')->nullable();
            $table->longText('alamat_surat_ibu')->nullable();
            $table->string('poskod_ibu')->nullable();
            $table->string('no_tel_ibu')->nullable();
            $table->integer('status_pekerjaan_ibu')->nullable();
            $table->integer('pendapatan_ibu')->nullable();
            $table->integer('tingal_bersama')->nullable();
            $table->string('nama_penjaga')->nullable();
            $table->string('no_ic_penjaga')->nullable();
            $table->longText('alamat_surat_penjaga')->nullable();
            $table->string('poskod_penjaga')->nullable();
            $table->string('no_tel_penjaga')->nullable();
            $table->integer('status_pekerjaan_penjaga')->nullable();
            $table->integer('pendapatan_penjaga')->nullable();
            $table->integer('pertalian_penjaga')->nullable();
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
        Schema::dropIfExists('permohonan_penjaga');
    }
};
