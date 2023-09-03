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
        Schema::create('bilik_asrama', function (Blueprint $table) {
            $table->id();
            $table->integer('tingkat_id')->nullable();
            $table->integer('blok_id')->nullable();
            $table->string('no_bilik')->nullable();
            $table->integer('status_bilik')->nullable();
            $table->integer('keadaan_bilik')->nullable();
            $table->integer('jenis_bilik')->nullable();
            $table->integer('is_deleted')->default(0);
            $table->integer('create_by')->nullable();
            $table->integer('update_by')->nullable();
            $table->integer('delete_by')->nullable();
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
        Schema::dropIfExists('bilik_asrama');
    }
};
