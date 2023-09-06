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
        Schema::table('permohonan_sijil_tahfizs', function (Blueprint $table) {
            $table->integer('template_jemputan_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_sijil_tahfizs', function (Blueprint $table) {
            $table->dropColumn('template_jemputan_id');
        });
    }
};
