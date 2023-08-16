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
        Schema::create('editor_artikel', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penuh')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat_dihubungi')->nullable();
            $table->integer('jenis_pengenalan')->nullable()->comment('1=mykad,2=passport');
            $table->string('butiran_pengenalan')->nullable();
            $table->integer('status')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('approved_by')->nullable();
            $table->datetime('approved_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('editor_artikel');
    }
};
