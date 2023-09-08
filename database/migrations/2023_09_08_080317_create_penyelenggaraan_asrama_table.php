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
        Schema::create('penyelenggaraan_asrama', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kerja')->nullable();
            $table->char('kategori')->nullable()->comment('R - Rutin, A - Aduan');
            $table->integer('status_aduan')->default(0)->comment('0 - Aduan baru, 1 - Buka, 2 - Tutup');
            $table->integer('status_kerja')->default(0)->comment('0 - Belum bermula, 1 - Sedang dijalankan, 2 - Selesai');
            $table->integer('keputusan_aduan')->default(0)->comment('0 - Belum selesai, 1 - Cemerlang, 2 - Memuaskan, 3 - Tidak Memuaskan, 4 - Perlu diperbaikai');
            $table->text('komen')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->date('tarikh_mula')->nullable();
            $table->date('tarikh_selesai')->nullable();
            $table->integer('check_by')->nullable();
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
        Schema::dropIfExists('penyelenggaraan_asrama');
    }
};
