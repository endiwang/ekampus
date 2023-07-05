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
        Schema::create('ijazah_maklumat_graduasi', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->nullable();
            $table->string('description')->nullable();
            $table->integer('document_type')->comment('1-dokumen baru 2- dokumen tambahan, 3-dokumen ganti(versi baru)')->nullable();
            $table->string('uploaded_document')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('ijazah_maklumat_graduasi');
    }
};
