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
        Schema::create('komen_artikel', function (Blueprint $table) {
            $table->id();
            $table->integer('artikel_id')->nullable();
            $table->string('komen')->nullable();
            $table->integer('editor')->nullable();
            $table->datetime('tarikh_komen')->nullable();
            $table->string('balasan')->nullable();
            $table->integer('penyumbang')->nullable();
            $table->datetime('tarikh_balasan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('komen_artikel');
    }
};
