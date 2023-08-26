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
        Schema::create('bayaran', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no')->nullable();
            $table->integer('bil_id')->nullable();
            $table->integer('pelajar_id')->nullable();
            $table->integer('yuran_id')->nullable();
            $table->date('date')->nullable();
            $table->string('description')->nullable();
            $table->text('gambar')->nullable();
            $table->text('resit')->nullable();
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
        Schema::dropIfExists('bayaran');
    }
};
