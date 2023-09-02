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
        Schema::table('pusat_peperiksaans', function (Blueprint $table) {
            $table->integer('had_jumlah_calon')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pusat_peperiksaans', function (Blueprint $table) {
            $table->dropColumn('had_jumlah_calon');
        });
    }
};
