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
        Schema::table('jadual_waktu', function (Blueprint $table) {
            $table->integer('semester_id')->after('pengajian_id')->nullable();
            $table->integer('status_pengajian')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jadual_waktu', function (Blueprint $table) {
            $table->dropColumn('semester_id');
            $table->dropColumn('status_pengajian');
        });
    }
};
