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
        Schema::create('syukbah', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->integer('kuota_pelajar')->default(0);
            $table->integer('jumlah_jam_kredit')->default(0);
            $table->integer('kursus_id')->nullable()->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_deleted')->nullable();
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
        Schema::dropIfExists('syukbah');
    }
};
