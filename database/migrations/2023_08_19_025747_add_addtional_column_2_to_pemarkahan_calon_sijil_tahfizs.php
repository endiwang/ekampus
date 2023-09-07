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
            $table->integer('examiner_id')->nullable();
            $table->integer('created_by')->nullable();
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
            $table->dropColumn('examiner_id');
            $table->dropColumn('created_by');
        });
    }
};
