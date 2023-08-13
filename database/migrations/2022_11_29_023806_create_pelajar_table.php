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
        Schema::create('pelajar', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('pelajar_id_old')->nullable()->comment('id dari db lama');
            $table->string('mohon_id_old')->nullable()->comment('id dari db lama');
            $table->integer('kursus_id');
            $table->integer('syukbah_id');
            $table->integer('kelas_id')->nullable();
            $table->string('no_matrik')->nullable();
            $table->string('sesi_id')->nullable();
            $table->integer('semester')->nullable();
            $table->integer('pusat_pengajian_id')->nullable()->default(1);
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->string('no_ic')->nullable();
            $table->text('alamat')->nullable();
            $table->string('poskod')->nullable();
            $table->string('bandar')->nullable();
            $table->integer('daerah_id')->nullable();
            $table->integer('negeri_id')->nullable();
            $table->integer('dun_id')->nullable();
            $table->integer('parlimen_id')->nullable();
            $table->string('no_tel')->nullable();
            $table->string('no_hp')->nullable();
            $table->char('jantina')->nullable();
            $table->date('tarikh_lahir')->nullable();
            $table->smallInteger('umur_ketika_mendaftar')->nullable();
            $table->char('keturunan_id')->nullable();
            $table->integer('negeri_kelahiran_id')->nullable()->comment('id dari table negeri');
            $table->char('warganegara')->nullable();
            $table->string('nama_sekolah')->nullable();
            $table->integer('tahun_peperiksaan')->nullable();
            $table->string('jumlah_matapelajaran')->nullable();
            $table->string('gred_percubaan_spm_bm')->nullable();
            $table->string('gred_percubaan_spm_ba')->nullable();
            $table->string('gred_percubaan_spm_bi')->nullable();
            $table->string('gred_sebenar_bm')->nullable();
            $table->string('gred_sebenar_ba')->nullable();
            $table->string('gred_sebenar_bi')->nullable();
            $table->string('gred_sebenar_pi')->nullable();
            $table->string('gred_sebenar_aqs')->nullable();
            $table->string('gred_sebenar_psi')->nullable();
            $table->string('gred_sebenar_art')->nullable();
            $table->string('gred_sebenar_ark')->nullable();
            $table->string('gred_sebenar_fizik')->nullable();
            $table->string('gred_sebenar_kimia')->nullable();
            $table->string('gred_sebenar_biologi')->nullable();
            $table->string('gred_sebenar_math')->nullable();
            $table->string('gred_sebenar_math_tambahan')->nullable();
            $table->string('gred_sebenar_akaun')->nullable();
            $table->string('sijil_setaraf')->nullable();
            $table->integer('tahun_sijil_setaraf')->nullable();
            $table->string('nama_sijil_setaraf')->nullable();
            $table->integer('tahun_stpm')->nullable();
            $table->integer('tahun_stam')->nullable();
            $table->text('nama_tilawah')->nullable();
            $table->text('cita_cita')->nullable();
            $table->text('sebab_memohon')->nullable();
            $table->text('kursus_dihadiri')->nullable();
            $table->text('kokurikulum_sekolah')->nullable();
            $table->string('status')->nullable();
            $table->string('img_pelajar')->nullable();

            $table->string('p_gred')->nullable();
            $table->string('p_gred_lain')->nullable();
            $table->string('p_gred_bm')->nullable();
            $table->string('p_gred_ba')->nullable();

            $table->tinyInteger('is_register')->nullable()->default(0);
            $table->string('gred_akhir')->nullable();
            $table->string('mata_akhir')->nullable();
            $table->string('kedudukan_result')->nullable();
            $table->date('tarikh_daftar')->nullable();
            $table->tinyInteger('is_berhenti')->default(0);
            $table->string('sebab_berhenti')->nullable();
            $table->smallInteger('kod_berhenti')->nullable();
            $table->tinyInteger('is_calc')->default(0);
            $table->tinyInteger('is_migrate')->default(0);
            $table->tinyInteger('is_gantung')->default(0);
            $table->tinyInteger('next_sem')->default(0);
            $table->smallInteger('jam_kredit')->nullable()->default(0);
            $table->smallInteger('jumlah_jam_kredit')->nullable();
            $table->tinyInteger('is_tamat')->nullable()->default(0);
            $table->tinyInteger('is_alumni')->nullable()->default(0);
            $table->tinyInteger('is_tasmik')->nullable()->default(0);
            $table->text('nama_arab')->nullable();
            $table->string('hafazan')->nullable();

            $table->tinyInteger('is_deleted')->nullable()->default(0);
            $table->string('deleted_by')->nullable();
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
        Schema::dropIfExists('pelajar');
    }
};
