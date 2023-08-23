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
        Schema::create('tatatertib_pelajar', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id')->nullable();
            $table->integer('aduan_salahlaku_pelajar_id')->nullable();
            $table->integer('siasatan_aduan_salahlaku_pelajar_id')->nullable();
            $table->string('laporan_kes')->nullable();
            $table->string('nota_hadir')->nullable();
            $table->string('fakta_kes')->nullable();
            $table->string('kertas_pertuduhan')->nullable();
            $table->string('keputusan_kes_hukuman')->nullable();
            $table->integer('status_hukuman')->default(0)->comment('0 belum berjalan, 1 sedang berjalan, 2 selesai');
            $table->string('nota_prosiding')->nullable();
            $table->string('update_by')->nullable();
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
        Schema::dropIfExists('tatatertib_pelajar');
    }
};
