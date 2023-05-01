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
        Schema::create('mpk_iso', function (Blueprint $table) {
            $table->id();
            $table->string('document_name')->nullable();
            $table->string('type')->nullable();
            $table->longText('description')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_extension')->nullable();
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
        Schema::dropIfExists('mpk_isos');
    }
};
