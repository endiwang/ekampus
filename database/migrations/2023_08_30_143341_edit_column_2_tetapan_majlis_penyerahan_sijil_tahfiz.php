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
        Schema::table('tetapan_majlis_penyerahan_sijil_tahfizs', function (Blueprint $table) {
            $table->string('pusat_pengajian_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tetapan_majlis_penyerahan_sijil_tahfizs', function (Blueprint $table) {
            $table->dropColumn('pusat_pengajian_id');
        });
    }
};
