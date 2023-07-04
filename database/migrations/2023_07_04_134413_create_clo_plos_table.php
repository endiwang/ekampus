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
        Schema::create('clo_plos', function (Blueprint $table) {
            $table->id();
            $table->integer('program_pengajian_id')->nullable();
            $table->integer('kursus_id')->nullable();
            $table->integer('pensyarah_id')->nullable();
            $table->integer('kelas_id')->nullable();
            $table->integer('clo_id')->nullable();
            $table->integer('plo_id')->nullable();
            $table->integer('jabatan_id')->nullable();
            $table->double('marks', 8,2)->nullable();
            $table->integer('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('is_deleted')->default(0);
            $table->integer('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('clo_plos');
    }
};
