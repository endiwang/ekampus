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
        Schema::create('pengambilan_sijil_tahfizs', function (Blueprint $table) {
            $table->id();
            $table->integer('permohonan_id');
            $table->date('tarikh_ambil_sijil')->nullable();
            $table->string('no_sijil')->nullable();
            $table->string('nama_pengambil_sijil')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('pengambilan_sijil_tahfizs');
    }
};
