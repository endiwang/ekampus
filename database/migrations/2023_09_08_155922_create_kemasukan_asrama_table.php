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
        Schema::create('kemasukan_asrama', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id')->nullable();
            $table->integer('status_profile')->default(0)->comment('0 - belum update, 1 - sudah update');
            $table->integer('bilik_asrama_id')->nullable();
            $table->integer('status')->default(0)->comment('0 - belum diproses, 1 - diterima, 2 - ditolak');
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
        Schema::dropIfExists('kemasukan_asrama');
    }
};
