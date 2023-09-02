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
        Schema::create('tuntutan_bayarans', function (Blueprint $table) {
            $table->id();
            $table->integer('pusat_pengajian_id')->nullable();
            $table->integer('bil_id')->nullable();
            $table->integer('semester')->nullable();
            $table->integer('sesi_id')->nullable();
            $table->string('description')->nullable();
            $table->integer('jumlah_pelajar')->nullable();
            $table->double('jumlah', 8,2)->nullable();
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
        Schema::dropIfExists('tuntutan_bayarans');
    }
};
