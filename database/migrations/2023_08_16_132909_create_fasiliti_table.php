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
        Schema::create('fasiliti', function (Blueprint $table) {
            $table->id();
            $table->integer('jenis')->nullable()->comment('1-fasiliti 2-peralatan');
            $table->string('kategori')->nullable()->comment('jenis jenis');
            $table->integer('kuantiti')->nullable();
            $table->integer('status_penggunaan')->nullable()->comment('1-digunakan 2-xdigunakan');
            $table->string('pengguna')->nullable()->comment('pengguna');
            $table->date('tarikh')->nullable();
            $table->time('masa')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('fasiliti');
    }
};
