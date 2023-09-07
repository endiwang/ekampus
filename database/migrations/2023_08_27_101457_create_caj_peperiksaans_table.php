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
        Schema::create('caj_peperiksaan', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->nullable();
            $table->integer('subjek_id')->nullable();
            $table->string('description')->nullable();
            $table->double('jumlah', 8, 2)->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('caj_peperiksaan');
    }
};
