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
        Schema::table('disiplin_pelajar', function (Blueprint $table) {
            $table->integer('pelajar_id')->nullable()->after('id');
            $table->longText('keterangan')->nullable()->after('siasatan_aduan_salahlaku_pelajar_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disiplin_pelajar', function (Blueprint $table) {
            $table->dropColumn('pelajar_id');
            $table->dropColumn('keterangan');
        });
    }
};
