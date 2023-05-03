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
        Schema::create('aktiviti', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program')->nullable();
            $table->date('tarikh_program')->nullable();
            $table->integer('jenis_hebahan')->nullable();
            $table->integer('jenis_hebahan_detail')->nullable();
            $table->integer('status_kelulusan')->nullable()->default(0);
            $table->date('tarikh_mula')->nullable();
            $table->date('tarikh_tamat')->nullable();
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
        Schema::dropIfExists('aktivitis');
    }
};
