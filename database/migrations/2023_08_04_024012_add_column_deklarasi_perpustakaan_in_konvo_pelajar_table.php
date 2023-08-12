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
        Schema::table('konvo_pelajar', function (Blueprint $table) {
            $table->integer('deklarasi_perpustakaan')->default(0)->after('saiz_kopiah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konvo_pelajar', function (Blueprint $table) {
            $table->dropColumn('deklarasi_perpustakaan');
        });
    }
};
