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
        Schema::create('permohonan_sijil_tahfizs', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id');
            $table->integer('masalah_penglihatan')->nullable();
            $table->integer('siri_id')->nullable(); //refer table tetapan peperiksaan sijil tahfiz
            $table->integer('pusat_peperiksaan_id')->default(0);
            $table->integer('pusat_peperiksaan_negeri_id')->default(0);
            $table->string('nama_tahfiz')->nullable();
            $table->text('alamat_tahfiz')->nullable();
            $table->string('poskod_tahfiz')->nullable();
            $table->integer('negeri_tahfiz')->nullable();
            $table->integer('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('is_deleted')->default(0);
            $table->integer('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('permohonan_sijil_tahfizs');
    }
};
