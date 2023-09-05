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
        Schema::create('permohonan_pindah_jam_credit', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('pelajar_id')->nullable();
            $table->string('kursus_id')->nullable();
            $table->string('sesi_id')->nullable();
            $table->string('syukbah_id')->nullable();
            $table->integer('status')->default(0);
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('permohonan_pindah_jam_credit');
    }
};