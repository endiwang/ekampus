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
        Schema::create('rekod_kompetensi_pensyarah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pensyarah')->nullable();
            $table->string('mykad')->nullable();
            $table->string('subjek')->nullable();
            $table->integer('semester')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('rekod_kompetensi_pensyarah');
    }
};
