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
        Schema::create('jadual_penggantian_pensyarah', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id')->nullable();
            $table->integer('subjek_id')->nullable();
            $table->integer('kelas_id')->nullable();
            $table->string('jenis')->nullable();
            $table->date('tarikh')->nullable();
            $table->integer('hari')->nullable();
            $table->time('masa_mula')->nullable();
            $table->time('masa_akhir')->nullable();
            $table->longText('catatan')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('jadual_penggantian_pensyarah');
    }
};
