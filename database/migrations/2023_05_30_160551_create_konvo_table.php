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
        Schema::create('konvo', function (Blueprint $table) {
            $table->id();
            $table->string('konvo_id_old')->nullable()->comment('Dari table lama');
            $table->char('type',2)->nullable();
            $table->integer('kursus_id')->nullable();
            $table->string('tajuk_konvo')->nullable();
            $table->date('tarikh')->nullable();
            $table->string('masa')->nullable();
            $table->string('hari')->nullable();
            $table->string('waktu')->nullable();
            $table->string('nama_tempat')->nullable();
            $table->mediumText('alamat_konvo')->nullable();
            $table->date('tarikh_cetakan')->nullable();
            $table->tinyInteger('status')->nullable()->default(0);
            $table->string('create_by')->nullable();
            $table->string('update_by')->nullable();
            $table->tinyInteger('is_close')->nullable()->default(0);
            $table->dateTime('close_date')->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(0);
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
        Schema::dropIfExists('konvo');
    }
};
