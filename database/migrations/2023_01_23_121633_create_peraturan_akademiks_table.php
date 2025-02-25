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
        Schema::create('peraturan_akademik', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('document_name')->nullable();
            $table->string('uploaded_document')->nullable();
            $table->integer('status')->default(1);
            $table->integer('is_deleted')->default(0);
            $table->integer('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('peraturan_akademik');
    }
};
