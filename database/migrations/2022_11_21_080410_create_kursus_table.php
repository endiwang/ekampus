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
        Schema::create('kursus', function (Blueprint $table) {
            $table->id();
            $table->char('kod',2)->nullable();
            $table->string('nama');
            $table->string('nama_arab')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->smallInteger('bil_sem_keseluruhan')->nullable();
            $table->smallInteger('bil_sem_setahun')->nullable();
            $table->string('pusat_pengajian_id')->nullable();
            $table->tinyInteger('is_deleted')->nullable();
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
        Schema::dropIfExists('kursus');
    }
};
