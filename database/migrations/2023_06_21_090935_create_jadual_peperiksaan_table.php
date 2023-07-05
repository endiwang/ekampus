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
        Schema::create('jadual_peperiksaan', function (Blueprint $table) {
            $table->id();
            $table->integer('tetapan_peperiksaan_id')->nullable();
            $table->integer('subjek_id')->nullable();
            $table->date('tarikh')->nullable();
            $table->time('masa')->nullable();
            $table->integer('bilangan_calon')->nullable();
            $table->string('lokasi')->nullable();
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
        Schema::dropIfExists('jadual_peperiksaan');
    }
};
