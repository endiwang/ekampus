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
        Schema::create('konvo_pelajar', function (Blueprint $table) {
            $table->id();
            $table->integer('konvo_id')->nullable();
            $table->integer('kursus_id')->nullable();
            $table->integer('pelajar_id')->nullable();
            $table->char('type', 2)->nullable()->default('B');
            $table->mediumText('catatan')->nullable();
            $table->integer('kehadiran')->nullable();
            $table->string('saiz_kopiah')->nullable();
            $table->string('create_by')->nullable();
            $table->string('update_by')->nullable();
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
        Schema::dropIfExists('konvo_pelajar');
    }
};
