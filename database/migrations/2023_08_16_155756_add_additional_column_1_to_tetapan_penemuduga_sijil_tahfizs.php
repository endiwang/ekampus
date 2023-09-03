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
        Schema::table('tetapan_penemuduga_sijil_tahfizs', function (Blueprint $table) {
            $table->integer('pusat_peperiksaan_id')->nullable();
            $table->integer('pusat_peperiksaan_negeri_id')->nullable();
            $table->integer('tetapan_peperiksaan_sijil_tahfiz_id')->nullable();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tetapan_penemuduga_sijil_tahfizs', function (Blueprint $table) {
            $table->dropColumn('pusat_peperiksaan_id');
            $table->dropColumn('pusat_peperiksaan_negeri_id');
            $table->dropColumn('tetapan_peperiksaan_sijil_tahfiz_id');
            $table->dropColumn('deleted_by');
        });
    }
};
