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
        Schema::create('jadual_warden', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->integer('bulan')->nullable();
            $table->integer('status')->default(0)->comment('0 tidak aktif, 1 aktif');
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
        Schema::dropIfExists('jadual_warden');
    }
};
