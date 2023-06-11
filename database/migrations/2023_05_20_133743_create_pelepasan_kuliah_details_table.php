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
        Schema::create('pelepasan_kuliah_details', function (Blueprint $table) {
            $table->id();
            $table->integer('pelepasan_kuliah_id')->nullable();
            $table->integer('staff_id')->nullable();
            $table->integer('status_pengesahan')->nullable();
            $table->longText('ulasan_pensyarah')->nullable();
            $table->date('tarikh_pengesahan')->nullable();
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
        Schema::dropIfExists('pelepasan_kuliah_details');
    }
};
