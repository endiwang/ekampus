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
        Schema::create('e_learning_timetables', function (Blueprint $table) {
            $table->id();
            $table->integer('kursus_id')->nullable();
            $table->integer('syllabus_id')->nullable();
            $table->integer('semester_id')->nullable();
            $table->integer('kelas_id')->nullable();
            $table->integer('staff_id')->nullable();
            $table->time('masa_mula')->nullable();
            $table->time('masa_akhir')->nullable();
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
        Schema::dropIfExists('e_learning_timetables');
    }
};
