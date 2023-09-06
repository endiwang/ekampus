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
        Schema::create('bil_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('bil_id')->nullable();
            $table->integer('yuran_id')->nullable();
            $table->string('description')->nullable();
            $table->double('amaun', 10, 2)->nullable();
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
        Schema::dropIfExists('bil_detail');
    }
};
