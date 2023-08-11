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
        Schema::create('vendor', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('nama_syarikat')->nullable();
            $table->string('no_tel_syarikat')->nullable();
            $table->string('nama_pengurus')->nullable();
            $table->string('no_tel_pengurus')->nullable();
            $table->string('emel_pengurus')->nullable();
            $table->text('alamat')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('vendor');
    }
};
