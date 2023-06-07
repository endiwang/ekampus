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
        Schema::table('permohonan', function (Blueprint $table) {
            $table->string('bandar_surat')->nullable()->after('alamat_surat');
            $table->string('poskod_surat')->nullable()->after('bandar_surat');
            $table->string('negeri_surat')->nullable()->after('poskod_surat');
            $table->string('kedaaan_fizikal')->nullable()->after('warganegara');
            $table->string('penyakit_kronik')->nullable()->after('kedaaan_fizikal');
            $table->string('rekod_kemasukan_wad')->nullable()->after('penyakit_kronik');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn('bandar_surat');
            $table->dropColumn('poskod_surat');
            $table->dropColumn('negeri_surat');
            $table->dropColumn('kedaaan_fizikal');
            $table->dropColumn('penyakit_kronik');
            $table->dropColumn('rekod_kemasukan_wad');
        });
    }
};
