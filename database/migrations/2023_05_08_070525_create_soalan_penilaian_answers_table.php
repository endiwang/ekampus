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
        Schema::create('soalan_penilaian_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('subjek_id')->nullable();
            $table->integer('kelas_id')->nullable();
            $table->integer('soalan_penilaian_id')->nullable();
            $table->integer('score')->nullable();
            $table->integer('submitted_by')->nullable();
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
        Schema::dropIfExists('soalan_penilaian_answers');
    }
};
