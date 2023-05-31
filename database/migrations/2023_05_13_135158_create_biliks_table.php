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
        Schema::create('bilik', function (Blueprint $table) {
            $table->id();
            $table->integer('old_bilik_id')->nullable();
            $table->integer('tingkat_id')->nullable();
            $table->integer('blok_id')->nullable();
            $table->string('nama_bilik')->nullable();
            $table->integer('status_bilik')->nullable();
            $table->integer('keadaan_bilik')->nullable();
            $table->string('jenis_bilik')->nullable();
            $table->integer('max_student')->nullable();
            $table->timestamp('create_dt')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('update_dt')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_deleted')->default(0);
            $table->timestamp('delete_dt')->nullable();
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
        Schema::dropIfExists('bilik');
    }
};
