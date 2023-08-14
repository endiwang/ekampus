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
        Schema::create('pelajar_semester_details', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_semester_id')->nullable();
            $table->integer('subjek_id')->nullable();
            $table->string('staff_id')->nullable();
            $table->double('kehadiran', 8,2)->nullable();
            $table->double('markah_30', 8,2)->nullable();
            $table->double('markah_40', 8,2)->nullable();
            $table->double('markah_60', 8,2)->nullable();
            $table->double('markah', 8,2)->nullable();
            $table->string('gred')->nullable();
            $table->double('pointer', 8,2)->nullable();
            $table->double('total_pointer', 8,2)->nullable();
            $table->string('status')->nullable();
            $table->string('status_c')->nullable();
            $table->double('status_subjek', 8,2)->nullable();
            $table->double('dur_subjek', 8,2)->nullable();
            $table->integer('bilangan_dur_subjek')->nullable();
            $table->string('kenyataan')->nullable();
            $table->integer('psd_id_old')->nullable();
            $table->integer('is_drop')->nullable();
            $table->string('drop_dt')->nullable();
            $table->integer('drop_by')->nullable();
            $table->integer('is_calc_new')->nullable();
            $table->longText('komen_staff')->nullable();
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
        Schema::dropIfExists('pelajar_semester_details');
    }
};
