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
        Schema::create('tarikh_keputusan', function (Blueprint $table) {
            $table->id();
            $table->integer('semester_no')->nullable();
            $table->integer('semester_terkini_id')->nullable();
            $table->date('tarikh_keputusan')->nullable();
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
        Schema::dropIfExists('tarikh_keputusan');
    }
};
