<?php

use App\Models\KemahiranInsaniah\PilihanRaya\Sesi;
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
        Schema::create('pr_sesi', function (Blueprint $table) {
            $table->id();
            $table->string('semester')->comment('sesi pilihan raya untuk musim / semester');
            $table->json('fasal_2')->nullable();
            $table->json('fasal_3')->nullable();
            $table->string('jenis')->nullable()->comment('Ijazah,Diploma,Sijil');
            $table->date('tarikh_penamaan_calon')->nullable();
            $table->date('tarikh_mengundi')->nullable();
            $table->timestamps();
        });

        Schema::create('pr_calon', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sesi::class);
            $table->string('nama');
            $table->integer('tahun_pengajian');
            $table->string('negeri_asal')->nullable();
            $table->string('semster')->nullable();
            $table->boolean('is_banin')->default(false);
            $table->boolean('is_banat')->default(false);
            $table->string('pointer_syafawi')->nullable();
            $table->string('pointer_tahriri')->nullable();
            $table->float('cgpa')->default(0);
            $table->json('pencadang')->comment('store name, ic and semester');
            $table->json('penyokong_cadangan')->comment('3 orang - nama, ic and semester');
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
        Schema::dropIfExists('pr_calon');
        Schema::dropIfExists('pr_sesi');
    }
};
