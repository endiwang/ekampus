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
        Schema::table('clo_plo_marks', function (Blueprint $table) {
            $table->integer('subjek_id')->after('kursus_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clo_plo_marks', function (Blueprint $table) {
            $table->dropColumn('subjek_id');
        });
    }
};
