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
        Schema::create('penilaian_berterusan_marks', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('subjek_id');
            $table->integer('penilaian_berterusan_item_id')->nullable();
            $table->integer('penilaian_berterusan_component_id')->nullable();
            $table->double('peratus_markah', 8, 2)->nullable();
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
        Schema::dropIfExists('penilaian_berterusan_marks');
    }
};
