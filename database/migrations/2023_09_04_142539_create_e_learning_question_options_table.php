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
        Schema::create('e_learning_question_options', function (Blueprint $table) {
            $table->id();
            $table->integer('question_id');
            $table->string('name')->nullable();
            $table->string('is_correct')->default(0);
            $table->double('mark', 8,2)->nullable();
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
        Schema::dropIfExists('e_learning_question_options');
    }
};
