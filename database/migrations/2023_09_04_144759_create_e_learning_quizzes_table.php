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
        Schema::create('e_learning_quizzes', function (Blueprint $table) {
            $table->id();
            $table->integer('kursus_id')->nullable();
            $table->integer('e_learning_syllabi_id')->nullable();
            $table->integer('semester_id')->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->double('total_mark', 8,2)->nullable();
            $table->double('minimum_mark', 8,2)->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('e_learning_quizzes');
    }
};
