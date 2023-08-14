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
        Schema::create('sesi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('kursus_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->date('tarikh_akhir_exam')->nullable();
            $table->date('tarikh_transkrip')->nullable();
            $table->integer('order')->nullable()->default(0);
            $table->tinyInteger('is_deleted')->nullable()->default(0);
            $table->string('deleted_by')->nullable();
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
        Schema::dropIfExists('sesi');
    }
};
