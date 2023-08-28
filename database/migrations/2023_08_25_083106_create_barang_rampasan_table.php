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
        Schema::create('barang_rampasan', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id')->nullable();
            $table->string('nama_pemilik')->nullable();
            $table->string('no_ic_pemilik')->nullable();
            $table->string('no_matrik_pemilik')->nullable();
            $table->string('no_pelekat')->nullable();
            $table->string('jenis_barang')->nullable()->comment('E - Electric, EN - Electronic, NE not Electric/Electronic');
            $table->string('jenama')->nullable();
            $table->string('model')->nullable();
            $table->string('warna')->nullable();
            $table->date('tarikh_rampasan')->nullable();
            $table->time('masa_rampasan')->nullable();
            $table->string('tempat_rampasan')->nullable();
            $table->text('sebab_rampasan')->nullable();
            $table->string('lampiran_rampasan')->nullable();
            $table->integer('status')->default(0)->comment('0 tidak dituntu, 1 dituntut');
            $table->string('create_by')->nullable();
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
        Schema::dropIfExists('barang_rampasan');
    }
};
