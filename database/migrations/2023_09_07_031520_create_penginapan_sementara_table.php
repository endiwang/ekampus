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
        Schema::create('penginapan_sementara', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id')->nullable();
            $table->string('no_rujukan')->nullable();
            $table->string('nama_institusi')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('nama_pelajar')->nullable();
            $table->string('mykad')->nullable();
            $table->string('no_tel')->nullable();
            $table->string('program_id')->nullable();
            $table->string('semester_id')->nullable();
            $table->string('nama_ibu_bapa_penjaga')->nullable();
            $table->string('no_tel_ibu_bapa_penjaga')->nullable();
            $table->integer('status')->default(0)->comment('0 baru, 1 diluluskan, 2 ditolak');
            $table->integer('update_by')->nullable();
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
        Schema::dropIfExists('penginapan_sementara');
    }
};
