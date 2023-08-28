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
        Schema::create('running_no', function (Blueprint $table) {
            $table->id();
            $table->integer('fasiliti')->nullable()->default(1)->comment('permohonan fasiliti');
            $table->integer('penginapan')->nullable()->default(1)->comment('permohonan fasiliti');
            $table->integer('kenderaan')->nullable()->default(1)->comment('permohonan fasiliti');
            $table->integer('pelekat')->nullable()->default(1)->comment('permohonan fasiliti');
            $table->integer('kuarters')->nullable()->default(1)->comment('permohonan fasiliti');
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
        Schema::dropIfExists('running_no');
    }
};
