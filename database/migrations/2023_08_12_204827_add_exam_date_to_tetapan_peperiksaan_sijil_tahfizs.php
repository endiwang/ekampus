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
        Schema::table('tetapan_peperiksaan_sijil_tahfizs', function (Blueprint $table) {
            $table->date('tarikh_peperiksaan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tetapan_peperiksaan_sijil_tahfizs', function (Blueprint $table) {
            $table->dropColumn('tarikh_peperiksaan');
        });
    }
};
