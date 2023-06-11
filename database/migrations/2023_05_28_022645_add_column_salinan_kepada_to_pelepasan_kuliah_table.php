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
        Schema::table('pelepasan_kuliah', function (Blueprint $table) {
            $table->string('salinan_kepada')->after('komen')->nullable();
            $table->string('tandatangan_oleh')->after('salinan_kepada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelepasan_kuliah', function (Blueprint $table) {
            $table->dropColumn('salinan_kepada');
            $table->dropColumn('tandatangan_oleh');
        });
    }
};
