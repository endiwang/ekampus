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
        Schema::create('e_learning_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('question_id');
            $table->integer('student_id');
            $table->longText('answer')->nullable();
            $table->integer('question_option_id')->nullable();
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
        Schema::dropIfExists('e_learning_answers');
    }
};
