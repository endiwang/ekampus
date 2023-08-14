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
        Schema::table('kursus', function (Blueprint $table) {
            $table->string('maklumat_cetakan')->after('nama')->nullable();
            $table->integer('is_syukbah')->after('pusat_pengajian_id')->nullable();
            $table->integer('is_paparan_login')->after('is_syukbah')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kursus', function (Blueprint $table) {
            $table->dropColumn('maklumat_cetakan');
            $table->dropColumn('is_syukbah');
            $table->dropColumn('is_paparan_login');
        });
    }
};
