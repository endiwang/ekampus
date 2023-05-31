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
        Schema::create('pelajar_berhenti', function (Blueprint $table) {
            $table->id();
            $table->integer('old_pelajar_berhenti_id')->nullable();
            $table->string('pelajar_id')->nullable();
            $table->date('tarikh_berhenti')->nullable();
            $table->string('sebab_berhenti')->nullable();
            $table->integer('kod_berhenti')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('pelajar_berhenti');
    }
};
