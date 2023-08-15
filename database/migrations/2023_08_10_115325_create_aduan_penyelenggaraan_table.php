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
        Schema::create('aduan_penyelenggaraan', function (Blueprint $table) {
            $table->id();
            $table->string('no_siri')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('kategori')->nullable();
            $table->char('type')->nullable();
            $table->integer('blok_id')->nullable();
            $table->integer('tingkat_id')->nullable();
            $table->integer('bilik_id')->nullable();
            $table->string('jenis_kerosakan')->nullable();
            $table->text('butiran')->nullable();
            $table->text('gambar')->nullable();
            $table->integer('status')->nullable();
            $table->text('butiran_vendor')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->integer('status_vendor')->nullable();
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
        Schema::dropIfExists('aduan_penyelenggaraan');
    }
};
