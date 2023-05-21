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
        Schema::create('tawaran_pemohon', function (Blueprint $table) {
            $table->id();
            $table->integer('tawaran_id')->nullable();
            $table->integer('permohonan_id')->nullable();
            $table->text('surat_tawaran')->nullable();
            $table->text('surat_biasiswa')->nullable();
            $table->text('surat_terimaan')->nullable();
            $table->date('tarikh_terima')->nullable();
            $table->mediumText('catatan')->nullable();
            $table->tinyInteger('is_terima')->nullable()->default(0);
            $table->string('create_by')->nullable();
            $table->string('update_by')->nullable();
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
        Schema::dropIfExists('tawaran_pemohon');
    }
};
