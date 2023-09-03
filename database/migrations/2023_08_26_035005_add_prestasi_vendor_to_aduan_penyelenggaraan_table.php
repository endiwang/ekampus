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
        Schema::table('aduan_penyelenggaraan', function (Blueprint $table) {
            $table->integer('prestasi_vendor')->nullable()->after('status_vendor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aduan_penyelenggaraan', function (Blueprint $table) {
            $table->dropColumn('prestasi_vendor');
        });
    }
};
