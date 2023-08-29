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
        Schema::table('kaunseling', function (Blueprint $table) {
            $table->boolean('matlamat_tercapai')->default(false)->after('hasil_kaunseling');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kaunseling', function (Blueprint $table) {
            $table->dropColumn(['matlamat_tercapai']);
        });
    }
};
