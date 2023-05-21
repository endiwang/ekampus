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
        Schema::create('jadual_waktu', function (Blueprint $table) {
            $table->id();
            $table->integer('kelas_id')->nullable();
            $table->integer('pengajian_id')->nullable();
            $table->integer('status')->nullable()->comment('1-Belum Disahkan, 2-Telah Disahkan');
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
        Schema::dropIfExists('jadual_waktu');
    }
};
