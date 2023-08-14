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
            $table->integer('pusat_temuduga_id')->nullable()->after('pusat_pengajian_id')->nullable();
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
            Schema::dropIfExists('pusat_temuduga_id');
        });
    }
};
