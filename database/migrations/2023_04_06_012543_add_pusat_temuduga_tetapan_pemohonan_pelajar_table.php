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
        //
        Schema::table('tetapan_permohonan_pelajar', function (Blueprint $table) {
            $table->text('pusat_temuduga')->after('maklumat_semakan_tawaran')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tetapan_permohonan_pelajar', function (Blueprint $table) {
            Schema::dropIfExists('pusat_temuduga');
        });
    }
};
