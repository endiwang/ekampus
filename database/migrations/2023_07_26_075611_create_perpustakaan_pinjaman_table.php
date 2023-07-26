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
        Schema::create('perpustakaan_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->integer('keahlian_id');
            $table->integer('bahan_id');
            $table->date('tarikh_pinjam');
            $table->date('tarikh_pulang');
            $table->integer('status');
            $table->string('denda');
            $table->integer('status_denda')->default(0)->comment('0 - tiada denda, 1 - belum bayar - 2 selesa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perpustakaan_pinjaman');
    }
};
