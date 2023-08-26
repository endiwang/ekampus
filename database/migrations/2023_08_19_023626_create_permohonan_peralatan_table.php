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
        Schema::create('permohonan_peralatan', function (Blueprint $table) {
            $table->id();
            $table->integer('permohonan_fasiliti_id')->nullable();
            $table->integer('peralatan_id')->nullable()->comment('fk_fasiliti');
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
        Schema::dropIfExists('permohonan_peralatan');
    }
};
