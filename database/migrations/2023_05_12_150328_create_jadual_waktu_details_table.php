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
        Schema::create('jadual_waktu_details', function (Blueprint $table) {
            $table->id();
            $table->integer('jadual_waktu_id')->nullable();
            $table->integer('subjek_id')->nullable();
            $table->integer('jam_kredit')->nullable();
            $table->string('staff_id')->nullable();
            $table->integer('hari')->nullable();
            $table->time('masa_mula')->nullable();
            $table->time('masa_akhir')->nullable();
            $table->string('lokasi')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('jadual_waktu_details');
    }
};
