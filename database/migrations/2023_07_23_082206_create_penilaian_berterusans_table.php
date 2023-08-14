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
        Schema::create('penilaian_berterusan', function (Blueprint $table) {
            $table->id();
            $table->integer('subjek_id');
            $table->double('peratus_aktiviti', 8, 2)->nullable();
            $table->double('peratus_peperiksaan', 8, 2)->nullable();
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
        Schema::dropIfExists('penilaian_berterusan');
    }
};
