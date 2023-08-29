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
        Schema::create('permohonan_penginapan', function (Blueprint $table) {
            $table->id();
            $table->string('no_permohonan')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('bilik')->nullable()->comment('1- bilikrehat1 2-bilikrehat2 3-ruangtamu1 4-ruangtamu2 5-ruangtamu3');
            $table->date('tarikh_masuk')->nullable();
            $table->integer('tempoh_hari')->nullable();
            $table->date('tarikh_keluar')->nullable();
            $table->string('tujuan')->nullable();
            $table->integer('status')->nullable()->comment('1-lulus 2-tolak');
            $table->integer('approved_by')->nullable();
            $table->string('status_kerja')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->date('tarikh_status_kerja')->nullable();
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
        Schema::dropIfExists('permohonan_penginapan');
    }
};
