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
        Schema::create('pensyarah_cadangan', function (Blueprint $table) {
            $table->id();
            $table->integer('kursus_id')->nullable();
            $table->integer('subjek_id')->nullable();
            $table->integer('semester_id')->nullable();
            $table->integer('sesi_id')->nullable();
            $table->integer('kelas_id')->nullable();
            $table->integer('staff_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pensyarah_cadangan');
    }
};
