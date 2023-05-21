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
        Schema::table('temuduga', function (Blueprint $table) {
            $table->text('sesi_id')->after('kursus_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temuduga', function (Blueprint $table) {
            Schema::dropIfExists('sesi_id');

        });
    }
};
