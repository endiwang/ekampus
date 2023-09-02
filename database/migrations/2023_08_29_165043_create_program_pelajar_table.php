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
        Schema::create('program_pelajar', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program')->nullable();
            $table->string('lokasi_program')->nullable();
            $table->text('maklumat_program')->nullable();
            $table->date('tarikh_mula')->nullable();
            $table->time('masa_mula')->nullable();
            $table->date('tarikh_tamat')->nullable();
            $table->time('masa_tamat')->nullable();
            $table->integer('jumlah_sesi')->nullable();
            $table->integer('jenis_kehadiran')->default(0)->comment('0 - tidak wajib hadir, 1 - wajib hadir');
            $table->string('update_by')->nullable();
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
        Schema::dropIfExists('program_pelajar');
    }
};
