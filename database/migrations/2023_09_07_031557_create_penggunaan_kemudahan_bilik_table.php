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
        Schema::create('penggunaan_kemudahan_bilik', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id')->nullable();
            $table->string('no_rujukan')->nullable();
            $table->integer('bilik_asrama_id')->nullable();
            $table->string('nama_persatuan')->nullable();
            $table->string('tujuan')->nullable();
            $table->date('tarikh_mula')->nullable();
            $table->date('tarikh_tamat')->nullable();
            $table->integer('status')->default(0)->comment('0 baru, 1 diluluskan, 2 ditolak');
            $table->integer('update_by')->nullable();
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
        Schema::dropIfExists('penggunaan_kemudahan_bilik');
    }
};
