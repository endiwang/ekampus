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
        Schema::create('ijazah_teses', function (Blueprint $table) {
            $table->id();
            $table->string('project_name')->nullable();
            $table->string('project_title')->nullable();
            $table->string('file_name')->nullable();
            $table->string('uploaded_document')->nullable();
            $table->longText('document_description')->nullable();
            $table->integer('status')->nullable();
            $table->longText('remarks')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('ijazah_teses');
    }
};
