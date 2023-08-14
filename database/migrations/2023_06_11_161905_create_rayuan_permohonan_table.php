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
        Schema::create('rayuan_permohonan', function (Blueprint $table) {
            $table->id();
            $table->integer('permohonan_id');
            $table->string('rayuan');
            $table->dateTime('rayuan_date');
            $table->string('rayuan_remark')->nullable();
            $table->dateTime('rayuan_open_date')->nullable();
            $table->integer('rayuan_open_by')->nullable();
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
        Schema::dropIfExists('rayuan_permohonan');
    }
};
