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
        Schema::create('permohonan_fasiliti', function (Blueprint $table) {
            $table->id();
            $table->string('no_permohonan')->nullable()->comment();
            $table->integer('user_id')->nullable();
            $table->string('document_name')->nullable();
            $table->string('upload_document')->nullable();
            $table->date('tarikh_penggunaan')->nullable();
            $table->integer('makan_minum')->nullable()->comment('1-sarapan 2-tghari 3-ptg 4-malam');            
            $table->integer('peserta')->nullable()->comment('1-VIP 2-xVIP');
            $table->integer('jumlah_peserta')->nullbale();
            $table->integer('fasiliti_id')->nullable()->comment('fk_fasiliti fasiliti');
            $table->integer('peralatan_id')->nullable()->comment('fk_fasiliti peralatan');
            $table->text('catatan_tambahan')->nullable();
            $table->integer('status_permohonan')->nullable()->comment('1-baru terima,2-proses 3-lulus 4-tolak');
            $table->integer('approved_by')->nullable();
            $table->datetime('approved_date')->nullable();
            $table->string('status_kerja')->nullable()->comment('kemaskini status keja olh vendor');
            $table->integer('vendor_id')->nullable();
            $table->datetime('tarikh_status_kerja')->nullable();
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
        Schema::dropIfExists('permohonan_fasiliti');
    }
};
