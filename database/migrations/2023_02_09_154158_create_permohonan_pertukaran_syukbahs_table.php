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
        Schema::create('permohonan_pertukaran_syukbah', function (Blueprint $table) {
            $table->id();
            $table->string('pel_syuk_id_old')->nullable()->comment('id dari db lama');
            $table->string('pelajar_id_old')->nullable()->comment('id dari db lama');
            $table->integer('pelajar_id')->nullable();
            $table->integer('old_syukbah_id')->nullable();
            $table->integer('new_syukbah_id')->nullable();
            $table->integer('semester_id')->nullable();
            $table->text('sebab_tukar')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('permohonan_pertukaran_syukbah');
    }
};
