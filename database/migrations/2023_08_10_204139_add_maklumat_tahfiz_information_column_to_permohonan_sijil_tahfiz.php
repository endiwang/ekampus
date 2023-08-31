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
        Schema::table('permohonan_sijil_tahfizs', function (Blueprint $table) {
            $table->string('tahun_mula');
            $table->string('tahun_tamat');
            $table->string('tahap_pencapaian_hafazan');
            $table->integer('jenis_pengajian');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_sijil_tahfizs', function (Blueprint $table) {
            $table->dropColumn('tahun_mula');
            $table->dropColumn('tahun_tamat');
            $table->dropColumn('tahap_pencapaian_hafazan');
            $table->dropColumn('jenis_pengajian');
        });
    }
};
