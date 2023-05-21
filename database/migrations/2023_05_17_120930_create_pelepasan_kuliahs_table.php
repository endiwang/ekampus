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
        Schema::create('pelepasan_kuliah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_permohonan')->nullable();
            $table->integer('student_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->date('tarikh_mula')->nullable();
            $table->date('tarikh_akhir')->nullable();
            $table->integer('jumlah_hari')->nullable();
            $table->string('sebab_permohonan')->nullable();
            $table->string('dokumen_sokongan')->nullable();
            $table->integer('status_pengesahan_pensyarah')->nullable();
            $table->timestamp('tarikh_pengesahan_pensyarah')->nullable();
            $table->longText('ulasan_pensyarah')->nullable();
            $table->integer('status')->nullable();
            $table->timestamp('tarikh_sokongan')->nullable();
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
        Schema::dropIfExists('pelepasan_kuliah');
    }
};
