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
        Schema::create('aktiviti_pdp', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('subjek_id')->nullable();
            $table->integer('kelas_id')->nullable();
            $table->longText('description')->nullable();
            $table->date('record_date')->nullable();
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
        Schema::dropIfExists('aktiviti_pdp');
    }
};
