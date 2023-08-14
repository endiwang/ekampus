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
        Schema::table('pelajar', function (Blueprint $table) {
            $table->string('alamat_surat')->nullable()->after('negeri_id');
            $table->string('bandar_surat')->nullable()->after('alamat_surat');
            $table->string('poskod_surat')->nullable()->after('bandar_surat');
            $table->integer('negeri_id_surat')->nullable()->after('poskod_surat');
            $table->char('bumiputra')->nullable()->after('warganegara');
            $table->char('mualaf')->nullable()->after('bumiputra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelajar', function (Blueprint $table) {
            $table->dropColumn('alamat_surat');
            $table->dropColumn('bandar_surat');
            $table->dropColumn('poskod_surat');
            $table->dropColumn('negeri_id_surat');
            $table->dropColumn('bumiputra');
            $table->dropColumn('mualaf');
        });
    }
};
