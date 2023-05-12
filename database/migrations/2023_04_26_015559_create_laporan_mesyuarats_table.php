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
        Schema::create('laporan_mesyuarat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mesyuarat')->nullable();
            $table->date('tarikh_mesyuarat')->nullable();
            $table->string('bahagian_terlibat')->nullable();
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
        Schema::dropIfExists('laporan_mesyuarat');
    }
};
