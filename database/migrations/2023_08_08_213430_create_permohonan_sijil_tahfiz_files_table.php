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
        Schema::create('permohonan_sijil_tahfiz_files', function (Blueprint $table) {
            $table->id();
            $table->integer('permohonan_sijil_tahfiz_id');
            $table->text('file_upload_name')->nullable();
            $table->text('file_upload_path')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('permohonan_sijil_tahfiz_files');
    }
};
