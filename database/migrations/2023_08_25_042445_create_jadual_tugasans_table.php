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
        Schema::create('pi_jadual_tugasan', function (Blueprint $table) {
            $table->id();
            $table->date('tarikh');
            $table->string('waktu_solat')->comment('simpan dlm bentuk comma separated: Subuh,Zohor,Asar,Maghrib,Isyak');
            $table->json('imam')->nullable()->comment('Store as list of users - name, email, phone, username, id');
            $table->json('bilal')->nullable()->comment('Store as list of users - name, email, phone, username, id');
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
        Schema::dropIfExists('pi_jadual_tugasan');
    }
};
