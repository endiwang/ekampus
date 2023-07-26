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
        Schema::create('perpustakaan_keahlian', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('ic_no');
            $table->string('no_matrik')->nullable();
            $table->string('no_telefon');
            $table->integer('is_public')->default('0')->comment('0 is staff or student , 1 is public');
            $table->integer('user_id')->nullable();
            $table->integer('status')->default('0')->comment('0 active , 1 inactive');
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
        Schema::dropIfExists('perpustakaan_keahlian');
    }
};
