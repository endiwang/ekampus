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
        Schema::table('jadual_waktu_details', function (Blueprint $table) {
            $table->string('jenis')->after('lokasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jadual_waktu_details', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });
    }
};
