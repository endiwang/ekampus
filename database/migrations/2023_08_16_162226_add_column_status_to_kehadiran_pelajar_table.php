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
        Schema::table('kehadiran_pelajar', function (Blueprint $table) {
            $table->string('status')->after('waktu')->nullable();
            $table->string('remark')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kehadiran_pelajar', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('remark');
        });
    }
};
