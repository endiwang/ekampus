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
        Schema::create('jadual_pensyarah_details', function (Blueprint $table) {
            $table->id();
            $table->integer('jadual_pensyarah_id')->nullable();
            $table->integer('jadual_waktu_detail_id')->nullable();
            $table->integer('staff_id')->nullable();
            $table->integer('subjek_id')->nullable();
            $table->integer('kelas_id')->nullable();
            $table->integer('hari')->nullable();
            $table->time('masa_mula')->nullable();
            $table->time('masa_akhir')->nullable();
            $table->string('lokasi')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('status')->nullable()->comment('0-Aktif, 2-Tidak Aktif');
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
        Schema::dropIfExists('jadual_pensyarah_details');
    }
};
