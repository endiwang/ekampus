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
            $table->string('attachment')->after('remark')->nullable();
            $table->integer('created_by')->after('attachment')->nullable();
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
            $table->dropColumn('attachment');
            $table->dropColumn('created_by');
        });
    }
};
