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
        Schema::create('penangguhan_pengajian', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id')->nullable();
            $table->integer('old_tangguh_id')->nullable();
            $table->string('pelajar_id_old')->nullable();
            $table->integer('semester_now_id')->nullable();
            $table->integer('is_gantung')->comment('0-tiada status 1- digantung semester, 2-tangguh semester')->default(0);
            $table->date('tarikh_proses')->nullable();
            $table->string('tempoh_penangguhan')->nullable();
            $table->longText('sebab_penangguhan');
            $table->integer('status')->default(0);
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('penangguhan_pengajian');
    }
};
