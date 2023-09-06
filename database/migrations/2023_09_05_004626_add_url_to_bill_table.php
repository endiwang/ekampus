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
        Schema::table('bil', function (Blueprint $table) {
            $table->string('id_hash', 255)->nullable()->after('invois');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bil', function (Blueprint $table) {
            $table->dropColumn('id_hash');
        });
    }
};
