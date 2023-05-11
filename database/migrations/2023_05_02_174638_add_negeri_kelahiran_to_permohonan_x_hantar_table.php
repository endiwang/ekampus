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
        Schema::table('permohonan_x_hantar', function (Blueprint $table) {
            $table->integer('negeri_kelahiran')->after('jantina')->nullable();
            $table->string('bumiputra')->after('keturunan')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_x_hantar', function (Blueprint $table) {
            $table->dropColumn('negeri_kelahiran');
            $table->dropColumn('bumiputra');
        });
    }
};
