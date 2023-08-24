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
        Schema::table('kaunseling', function (Blueprint $table) {
            $table->dropColumn(['jenis_fasiliti']);

            /** Perkara 1 */
            $table->dateTime('started_at')->nullable();
            $table->datetime('ended_at')->nullable();
            $table->string('jenis_kes')->nullable()->comment('Jenis kes - lookup key: kaunseling.jenis-kes');
            $table->text('latar_belakang')->nullable();
            $table->text('situasi_semasa')->nullable()->comment('Situasi semasa Sosial / Emosi');
            $table->text('sejarah_kesihatan')->nullable()->comment('Sejarah kesihatan Diri / Psikologi');
            $table->text('harapan_hasil')->nullable()->comment('Harapan hasil kaunseling');
            $table->text('cadangan_tindakan')->nullable()->comment('Cadangan tindakan kaunselor');

            /** Perkara 2 */
            $table->string('jenis_kaunseling')->nullable()->comment('Jenis kaunseling - lookup key: kaunseling.jenis-kaunseling');
            $table->string('kekerapan_kaunseling')->nullable()->comment('Kekerapan kaunseling');
            $table->string('tujuan_kaunseling')->nullable()->comment('Tujuan kaunseling');
            $table->string('jenis_pengujian')->nullable()->comment('Jenis pengujian - lookup key: kaunseling.jenis-pengujian');
            $table->text('hasil_kaunseling')->nullable()->comment('Hasil kaunseling');
            $table->text('hasil_kepuasan')->nullable()->comment('Hasil kepuasan kaunseling');

            /** Perkara 3 */
            $table->text('ringkasan')->nullable()->comment('Ringkasan kaunseling');
            $table->text('hasil_konsultasi')->nullable()->comment('Hasil kaunseling');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kaunseling', function (Blueprint $table) {
            $table->string('jenis_fasiliti')->nullable();
            $table->dropColumn([
                'started_at',
                'ended_at',
                'jenis_kes',
                'latar_belakang',
                'situasi_semasa',
                'sejarah_kesihatan',
                'harapan_hasil',
                'cadangan_tindakan',
                'jenis_kaunseling',
                'kekerapan_kaunseling',
                'tujuan_kaunseling',
                'jenis_pengujian',
                'hasil_kaunseling',
                'hasil_kepuasan',
                'ringkasan',
                'hasil_konsultasi',
            ]);
        });
    }
};
