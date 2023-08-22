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
        Schema::create('persiapan_peperiksaan_details', function (Blueprint $table) {
            $table->id();
            $table->integer('persiapan_peperiksaan_id')->nullable();
            $table->string('item')->nullable();
            $table->integer('kuantiti')->nullable();
            $table->string('catatan')->nullable();
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
        Schema::dropIfExists('persiapan_peperiksaan_details');
    }
};
