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
        Schema::create('venue_peperiksaan_sijil_tahfizs', function (Blueprint $table) {
            $table->id();
            $table->integer('negeri_id');
            $table->text('address')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('venue_peperiksaan_sijil_tahfizs');
    }
};
