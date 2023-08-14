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
        Schema::create('penilaian_berterusan_components', function (Blueprint $table) {
            $table->id();
            $table->integer('subjek_id');
            $table->integer('penilaian_berterusan_item_id');
            $table->string('name')->nullable();
            $table->double('peratus_markah')->nullable();
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
        Schema::dropIfExists('penilaian_berterusan_components');
    }
};
