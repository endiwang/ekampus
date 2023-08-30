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
        Schema::table('template_jemputan_majlis_pensijilans', function (Blueprint $table) {
            $table->integer('majlis_id')->nullable()->after('name');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('template_jemputan_majlis_pensijilans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
