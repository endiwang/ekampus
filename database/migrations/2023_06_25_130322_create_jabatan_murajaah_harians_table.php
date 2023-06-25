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
        Schema::create('jabatan_murajaah_harian', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id');
            $table->string('surah')->nullable();
            $table->string('juzuk')->nullable();
            $table->string('ayat_akhir')->nullable();
            $table->integer('page_start')->nullable();
            $table->integer('page_end')->nullable();
            $table->integer('total_page')->nullable();
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
        Schema::dropIfExists('jabatan_murajaah_harian');
    }
};
