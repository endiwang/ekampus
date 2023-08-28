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
        Schema::table('pemarkahan_calon_sijil_tahfizs', function (Blueprint $table) {
            $table->integer('status_hadir_ujian_shafawi')->nullable()->default(0);
            $table->integer('status_hadir_ujian_tahriri')->nullable()->default(0);
            $table->integer('status_hadir_ujian_pengetahuan_islam')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemarkahan_calon_sijil_tahfizs', function (Blueprint $table) {
            $table->dropColumn('status_hadir_ujian_shafawi');
            $table->dropColumn('status_hadir_ujian_tahriri');
            $table->dropColumn('status_hadir_ujian_pengetahuan_islam');
        });
    }
};
