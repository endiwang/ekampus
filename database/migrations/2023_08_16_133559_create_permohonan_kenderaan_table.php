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
        Schema::create('permohonan_kenderaan', function (Blueprint $table) {
            $table->id();
            $table->string('no_permohonan')->nullable();
            $table->integer('user_id')->nullable();
            $table->date('tarikh_penggunaan')->nullable();
            $table->time('masa')->nullable();
            $table->string('tempat')->nullable();
            $table->integer('bil_penumpang')->nullable();
            $table->integer('jenis_kenderaan')->nullable()->comment('1-bas 2-van 3-serena 4-persona 5-persona-premium 6-pajero');
            $table->string('tujuan')->nullable();
            $table->integer('status')->nullable()->comment('1-lulus 0-gagal');
            $table->integer('approved_by')->nullable();
            $table->datetime('tarikh_approved')->nullable();
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
        Schema::dropIfExists('permohonan_kenderaan');
    }
};
