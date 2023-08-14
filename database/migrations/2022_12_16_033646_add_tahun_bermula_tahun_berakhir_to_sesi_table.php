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
        Schema::table('sesi', function (Blueprint $table) {
            $table->integer('tahun_bermula')->nullable()->after('kursus_id');
            $table->integer('tahun_berakhir')->nullable()->after('tahun_bermula');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sesi', function (Blueprint $table) {
            $table->dropColumn('tahun_bermula');
            $table->dropColumn('tahun_akhir');
        });
    }
};
