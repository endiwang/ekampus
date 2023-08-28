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
        Schema::table('jadual_peperiksaan', function (Blueprint $table) {
            $table->time('masa_akhir')->after('masa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jadual_peperiksaan', function (Blueprint $table) {
            $table->dropColumn('masa_akhir');
        });
    }
};
