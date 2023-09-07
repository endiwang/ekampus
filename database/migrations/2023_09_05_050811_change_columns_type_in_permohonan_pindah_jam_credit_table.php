<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonan_pindah_jam_credit', function (Blueprint $table) {
            $table->integer('kursus_id')->change();
            $table->integer('sesi_id')->change();
            $table->integer('syukbah_id')->change();
            $table->integer('status')->comment('0 > Default, 1 > Lulus ,2 > Gagal')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_pindah_jam_credit', function (Blueprint $table) {
            $table->string('kursus_id')->change();
            $table->string('sesi_id')->change();
            $table->string('syukbah_id')->change();
            $table->integer('status')->change();
        });
    }
};