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
        Schema::create('rayuan_tatatertib_pelajar', function (Blueprint $table) {
            $table->id();
            $table->integer('tatatertib_pelajar_id')->nullable();
            $table->string('surat_rayuan')->nullable();
            $table->string('keputusan_rayuan')->nullable();
            $table->string('laporan_rayuan')->nullable();
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
        Schema::dropIfExists('rayuan_tatatertib_pelajar');
    }
};
