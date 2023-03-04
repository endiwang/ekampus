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
        Schema::create('temuduga', function (Blueprint $table) {
            $table->id();
            $table->string('no_rujukan')->nullable();
            $table->integer('kursus_id')->nullable();
            $table->integer('pusat_pengajian_id')->nullable();
            $table->string('tajuk_borang')->nullable();
            $table->date('tarikh')->nullable();
            $table->string('masa')->nullable();
            $table->string('hari')->nullable();
            $table->string('waktu')->nullable();
            $table->string('nama_tempat')->nullable();
            $table->string('alamat_temuduga')->nullable();
            $table->date('tkh_cetakan')->nullable();
            $table->string('id_ketua')->nullable();
            $table->char('temuduga_type')->nullable()->default('B');
            $table->tinyInteger('is_close')->nullable()->default(0);
            $table->dateTime('close_at')->nullable();
            $table->tinyInteger('is_sph')->nullable()->default(0);
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
        Schema::dropIfExists('temuduga');
    }
};
