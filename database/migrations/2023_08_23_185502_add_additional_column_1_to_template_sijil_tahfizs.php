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
        Schema::table('template_sijil_tahfizs', function (Blueprint $table) {
            $table->string('orientation')->nullable()->default('landscape');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('template_sijil_tahfizs', function (Blueprint $table) {
            $table->dropColumn('orientation');
        });
    }
};
