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
        Schema::create('kenderaan_sitaan', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id')->nullable();
            $table->string('nama_pemilik')->nullable();
            $table->string('no_ic_pemilik')->nullable();
            $table->string('no_matrik_pemilik')->nullable();
            $table->string('no_pelekat')->nullable();
            $table->string('jenis_kenderaan')->nullable()->comment('K - Kereta, M - Motor');
            $table->string('jenama')->nullable();
            $table->string('model')->nullable();
            $table->string('warna')->nullable();
            $table->string('no_pendaftaran')->nullable();
            $table->date('tarikh_sita')->nullable();
            $table->time('masa_sita')->nullable();
            $table->string('tempat_sita')->nullable();
            $table->text('sebab_sita')->nullable();
            $table->string('lampiran_sita')->nullable();
            $table->integer('status')->default(0)->comment('0 tidak dituntu, 1 dituntut');
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
        Schema::dropIfExists('kenderaan_sitaan');
    }
};
