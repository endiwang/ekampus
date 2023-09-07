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
        Schema::create('bantuan_kebajikan', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id')->nullable();
            $table->string('no_rujukan')->nullable();
            $table->integer('bantuan_id')->nullable();
            $table->string('lain_lain')->nullable();
            $table->string('kad_pengenalan')->nullable();
            $table->string('sijil_kematian')->nullable();
            $table->string('akaun_bank')->nullable();
            $table->string('bukti_bayaran')->nullable();
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
        Schema::dropIfExists('bantuan_kebajikan');
    }
};
