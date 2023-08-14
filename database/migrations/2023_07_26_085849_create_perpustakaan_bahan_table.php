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
        Schema::create('perpustakaan_bahan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('isbn');
            $table->string('lokasi');
            $table->integer('status')->default(0)->comment('0 ada, 1 dipinjam');
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
        Schema::dropIfExists('perpustakaan_bahan');
    }
};
