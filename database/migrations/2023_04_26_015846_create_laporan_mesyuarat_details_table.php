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
        Schema::create('laporan_mesyuarat_details', function (Blueprint $table) {
            $table->id();
            $table->integer('laporan_mesyuarat_id')->nullable();
            $table->string('file_name')->nullable();
            $table->longText('description')->nullable();
            $table->string('file_extension')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('type')->nullable()->default(0);
            $table->integer('uploaded_by')->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(0);
            $table->integer('deleted_by')->nullable();
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
        Schema::dropIfExists('laporan_mesyuarat_details');
    }
};
