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
        Schema::create('pekerjaan_alumni', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('pelajar_id');
            $table->text('nama_syarikat')->nullable();
            $table->text('jawatan')->nullable();
            $table->integer('bidang_industri')->nullable();
            $table->date('tarikh_mula')->nullable();
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
        Schema::dropIfExists('pekerjaan_alumni');
    }
};