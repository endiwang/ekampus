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
        Schema::create('borang_kaji_selidik', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('success_msg')->nullable();
            $table->integer('is_active')->default(1);
            $table->longText('json')->nullable();
            $table->longText('html')->nullable();
            $table->string('create_by')->nullable();
            $table->integer('update_by')->nullable();
            $table->tinyInteger('is_deleted')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('borang_kaji_selidik');
    }
};
