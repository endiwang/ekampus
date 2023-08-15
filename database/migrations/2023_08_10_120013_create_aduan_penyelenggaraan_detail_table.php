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
        Schema::create('aduan_penyelenggaraan_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('aduan_penyelenggaraan_id')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->date('tarikh_kerja')->nullable();
            $table->text('butiran')->nullable();
            $table->text('gambar')->nullable();
            $table->integer('is_submit')->nullable();
            $table->text('reject_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aduan_penyelenggaraan_detail');
    }
};
