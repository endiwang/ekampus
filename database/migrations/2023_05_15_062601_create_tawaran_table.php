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
        Schema::create('tawaran', function (Blueprint $table) {
            $table->id();
            $table->string('tawaran_id_old')->nullable()->comment('Dari table lama');
            $table->char('type',2)->nullable();
            $table->integer('kursus_id')->nullable();
            $table->integer('pusat_id')->nullable();
            $table->integer('sesi_id')->nullable();
            $table->string('tajuk_tawaran')->nullable();
            $table->date('tarikh_surat')->nullable();
            $table->date('tarikh')->nullable();
            $table->string('masa')->nullable();
            $table->string('hari')->nullable();
            $table->string('waktu')->nullable();
            $table->string('nama_tempat')->nullable();
            $table->mediumText('alamat_pendaftaran')->nullable();
            $table->tinyInteger('status')->nullable()->default(0);
            $table->tinyInteger('close_tawaran')->nullable()->default(0);
            $table->char('tawaran_type',2)->nullable()->default('B');
            $table->string('create_by')->nullable();
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
        Schema::dropIfExists('tawaran');
    }
};
