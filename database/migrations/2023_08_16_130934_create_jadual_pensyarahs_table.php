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
        Schema::create('jadual_pensyarah', function (Blueprint $table) {
            $table->id();
            $table->integer('jadual_waktu_id')->nullable();
            $table->integer('staff_id')->nullable();
            $table->integer('kursus_id')->nullable();
            $table->integer('semester_id')->nullable();
            $table->string('sesi_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('status')->nullable()->comment('0-Aktif, 2-Tidak Aktif');
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
        Schema::dropIfExists('jadual_pensyarah');
    }
};
