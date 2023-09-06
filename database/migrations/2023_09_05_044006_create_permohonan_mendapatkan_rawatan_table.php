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
        Schema::create('permohonan_mendapatkan_rawatan', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id')->nullable();
            $table->string('no_rujukan')->nullable();
            $table->integer('penyakit_id')->nullable();
            $table->string('lain_lain')->nullable();
            $table->string('dokument_sokongan')->nullable();
            $table->integer('status')->default(0)->comment('0 baru, 1 diluluskan, 2 ditolak');
            $table->string('bukti_hadir')->nullable();
            $table->string('status_rawatan')->default('0')->comment('0 belum mendapatkan rawatan, 1 sudah dirawat');
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
        Schema::dropIfExists('permohonan_mendapatkan_rawatan');
    }
};
