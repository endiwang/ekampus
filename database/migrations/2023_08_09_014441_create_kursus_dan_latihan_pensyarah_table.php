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
        Schema::create('kursus_dan_latihan_pensyarah', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Nama kursus');
            $table->string('document_name')->nullable()->comment('Nama fail ori');
            $table->string('upload_document')->nullable()->comment('upload path');
            $table->integer('item')->nullable()->comment('1=Kertas Cadangan dan Kelulusan, 2=Laporan Pelaksanaan Kursus 3=Laporan Maklumbalas kursus');
            $table->integer('year')->nullable()->comment('tahuan item');
            $table->integer('is_deleted')->nullable()->comment('isdeleted?');
            $table->integer('deleted_by')->nullable()->comment('fk_user');
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
        Schema::dropIfExists('kursus_dan_latihan_pensyarah');
    }
};

$table->id();
$table->char('kod', 2)->nullable();
$table->string('nama');
$table->string('nama_arab')->nullable();
$table->tinyInteger('status')->default(0);
$table->smallInteger('bil_sem_keseluruhan')->nullable();
$table->smallInteger('bil_sem_setahun')->nullable();
$table->string('pusat_pengajian_id')->nullable();
$table->tinyInteger('is_deleted')->nullable();
$table->string('deleted_by')->nullable();
$table->softDeletes();
$table->timestamps();
