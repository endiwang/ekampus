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
            $table->integer('pemohon_id')->nullable()->after('pelajar_id');            
            $table->integer('permohonan_sijil_tahfiz_id')->nullable()->after('pemohon_id');
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
            $table->dropColumn('pemohon_id');            
            $table->dropColumn('permohonan_sijil_tahfiz_id');
        });
    }
};
