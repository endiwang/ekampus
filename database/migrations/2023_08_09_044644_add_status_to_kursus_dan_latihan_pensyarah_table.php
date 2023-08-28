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
        Schema::table('kursus_dan_latihan_pensyarah', function (Blueprint $table) {
            $table->integer('status')->after('year')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kursus_dan_latihan_pensyarah', function (Blueprint $table) {
            $table->dropColumn('status');
        });

    }
};
