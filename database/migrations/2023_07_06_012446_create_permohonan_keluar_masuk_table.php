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
        Schema::create('permohonan_keluar_masuk', function (Blueprint $table) {
            $table->id();
            $table->integer('pelepasan_kuliah_id')->nullable();
            $table->integer('pemohon_pelajar_id')->nullable();
            $table->integer('pemohon_user_id')->nullable();
            $table->date('tarikh_keluar')->nullable();
            $table->date('tarikh_masuk')->nullable();
            $table->integer('jumlah_hari')->nullable();
            $table->string('sebab_permohonan')->nullable();
            $table->string('dokumen_sokongan')->nullable();
            $table->integer('status')->nullable();
            $table->integer('diproses_oleh')->nullable();
            $table->timestamp('tarikh_proses')->nullable();
            $table->longText('komen')->nullable();
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
        Schema::dropIfExists('permohonan_keluar_masuk');
    }
};
