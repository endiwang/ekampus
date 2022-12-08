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
        Schema::create('subjek', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('kursus_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('kod_subjek')->nullable();
            $table->string('maklumat_tambahan')->nullable();
            $table->integer('kredit');
            $table->integer('jumlah_markah')->nullable();
            $table->tinyInteger('is_alquran')->default(0);
            $table->tinyInteger('is_calc')->nullable()->default(0);
            $table->tinyInteger('is_print')->nullable()->default(0);
            $table->char('type')->nullable()->default('S');
            $table->text('nama_arab')->nullable();
            $table->tinyInteger('sort')->nullable()->default(0);
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
        Schema::dropIfExists('subjek');
    }
};
