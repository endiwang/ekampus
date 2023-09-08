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
        Schema::table('bilik_asrama', function (Blueprint $table) {
            $table->integer('kekosongan')->nullable()->after('jenis_bilik');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bilik_asrama', function (Blueprint $table) {
            $table->dropColumn('kekosongan');
        });
    }
};
