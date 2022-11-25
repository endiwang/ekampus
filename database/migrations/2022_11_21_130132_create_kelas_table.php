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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('kapasiti_pelajar')->nullable()->default(0);
            $table->string('semasa_jantina')->nullable();
            $table->integer('semasa_syukbah_id')->nullable();
            $table->integer('semasa_semester_id')->nullable();
            $table->string('jadual_jantina')->nullable();
            $table->integer('jadual_syukbah_id')->nullable();
            $table->integer('jadual_semester_id')->nullable();
            $table->integer('jumlah_pelajar')->nullable();
            $table->string('sesi')->nullable();
            $table->integer('pusat_pengajian_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_deleted')->nullable()->default(0);
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('kelas');
    }
};
