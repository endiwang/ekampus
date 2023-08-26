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
        Schema::create('permohonan_kuarters', function (Blueprint $table) {
            $table->id();
            $table->string('no_permohonan')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('no_pengenalan')->nullable();
            $table->integer('warganegara')->nullable()->comment('1-warga 2-xwarga');
            $table->integer('status_perkahwinan')->nullable()->comment('1-bujang 2-kahwin 3-janda 4-duda');
            $table->string('nama_pasangan')->nullable();
            $table->integer('bil_anak')->nullable();
            $table->integer('bil_oku')->nullable()->default(0);
            $table->string('jawatan_gred')->nullable();
            $table->decimal('gaji_pokok')->nullable();
            $table->date('tarikh_khidmat_kerajaan');
            $table->date('tarikh_khidmat_dq');
            $table->text('alamat_sekarang')->nullable();
            $table->text('alamat_rumah')->nullable();
            $table->integer('cara_beli_rumah')->nullable()->comment('1-tunai 2-pinjaman krjan 3-banak');
            $table->integer('jarak_rumah_dq')->nullable();
            $table->integer('loan_pasangan')->nullable()->comment('1-ada 0-tiada');
            $table->text('alamat_rumah2')->nullable()->comment('alamat rumah pasangan jika ada');
            $table->text('alasan_mohon')->nullable();
            $table->integer('status')->nullable()->comment('1-diterima 2-proses 3-lulus 4-gagal');
            $table->integer('approved_by')->nullable();
            $table->date('tarikh_approved')->nullable();
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
        Schema::dropIfExists('permohonan_kuarters');
    }
};
