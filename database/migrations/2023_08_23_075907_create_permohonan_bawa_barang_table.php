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
        Schema::create('permohonan_bawa_barang', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id')->nullable();
            $table->string('no_rujukan')->nullable();
            $table->string('jenis_barang')->nullable()->comment('E - Electric, EN - Electronic, NE not Electric/Electronic');
            $table->string('jenama')->nullable();
            $table->string('model')->nullable();
            $table->string('kuasa')->nullable();
            $table->string('warna')->nullable();
            $table->text('sebab')->nullable();
            $table->string('gambar_barang')->nullable();
            $table->integer('status')->default(0)->comment('0 baru, 1 lulus, 2 tak lulus');
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
        Schema::dropIfExists('permohonan_bawa_barang');
    }
};
