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
        Schema::create('clo_plo_marks', function (Blueprint $table) {
            $table->id();
            $table->integer('clo_plo_id')->nullable();
            $table->integer('pelajar_id')->nullable();
            $table->integer('kursus_id')->nullable();
            $table->integer('semester_terkini_id')->nullable();
            $table->double('clo_marks', 8,2)->nullable();
            $table->double('plo_marks', 8,2)->nullable();
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
        Schema::dropIfExists('clo_plo_marks');
    }
};
