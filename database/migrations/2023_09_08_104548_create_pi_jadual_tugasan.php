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
        $this->down();
        Schema::create('pi_jadual_tugasan', function (Blueprint $table) {
            $table->id();
            $table->date('tarikh');
            $table->boolean('is_bilal')->default(false);
            $table->boolean('is_imam')->default(false);
            $table->boolean('is_subuh')->default(false);
            $table->boolean('is_zohor')->default(false);
            $table->boolean('is_asar')->default(false);
            $table->boolean('is_maghrib')->default(false);
            $table->boolean('is_isyak')->default(false);
            $table->json('user');
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
