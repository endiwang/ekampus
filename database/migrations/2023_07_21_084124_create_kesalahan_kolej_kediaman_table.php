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
        Schema::create('kesalahan_kolej_kediaman', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kesalahan');
            $table->integer('status')->default(0)->comment('0 - aktif, 1 - tidak aktif');
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
        Schema::dropIfExists('kesalahan_kolej_kediaman');
    }
};
