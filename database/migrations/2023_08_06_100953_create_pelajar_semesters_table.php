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
        Schema::create('pelajar_semesters', function (Blueprint $table) {
            $table->id();
            $table->string('pelajar_id')->nullable();
            $table->integer('sesi_id')->nullable();
            $table->integer('semester')->nullable();
            $table->integer('syukbah_id')->nullable();
            $table->integer('semester_now_id')->nullable();
            $table->integer('jam_kredit')->nullable();
            $table->double('jumlah_markah', 8,2)->nullable();
            $table->double('png')->nullable();
            $table->integer('jam_kredit_keseluruhan')->nullable();
            $table->double('jumlah_markah_keseluruhan', 8,1)->nullable();
            $table->double('pngk', 8,2)->nullable();
            $table->string('keputusan')->nullable();
            $table->string('pangkat')->nullable();
            $table->double('jumlah_markah_semester', 8,2)->nullable();
            $table->integer('jam_kredit_semester')->nullable();
            $table->integer('semester_seterusnya')->default(0);
            $table->integer('is_deleted')->default(0);
            $table->integer('is_gantung')->default(0);
            $table->integer('is_cetak_slip')->default(0);
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
        Schema::dropIfExists('pelajar_semesters');
    }
};
