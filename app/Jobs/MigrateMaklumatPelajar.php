<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Pelajar;
use App\Models\User;
use App\Models\OldDatabase\sis_tblpelajar;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class MigrateMaklumatPelajar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $student_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($student_id)
    {
        $this->student_id = $student_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $datum = sis_tblpelajar::where('pelajar_id',$this->student_id)->first();


        $temp = User::where('username', $datum->p_nokp)->first();
        if($temp != NULL)
        {
                    if(str_contains($datum->p_tkh_lahir, '0000'))
                    {
                        $tarikh_lahir = NULL;
                    }else{
                        $tarikh_lahir = Carbon::parse($datum->p_tkh_lahir)->toDateString();
                    }

                    if(str_contains($datum->tarikh_daftar, '0000'))
                    {
                        $tarikh_daftar = NULL;
                    }else{
                        $tarikh_daftar = Carbon::parse($datum->tarikh_daftar)->toDateString();
                    }

                    if(str_contains($datum->tarikh_berhenti ,'0000'))
                    {
                        $tarikh_berhenti = NULL;
                    }else{
                        $tarikh_berhenti = Carbon::parse($datum->tarikh_berhenti)->toDateString();
                    }

            Pelajar::create([
                'user_id' => $temp->id,
                'pelajar_id_old' => $datum->pelajar_id,
                'mohon_id_old' => $datum->mohon_id,
                'kursus_id' => $datum->kursus_id,
                'syukbah_id' => $datum->syukbah_id,
                'kelas_id' => $datum->kelas_id,
                'no_matrik' => $datum->no_matrik,
                'sesi_id' => $datum->sesi_id,
                'semester' => $datum->semester,
                'pusat_pengajian_id' => $datum->pusat_id,
                'nama' => $datum->p_nama,
                'email' => $datum->p_email,
                'no_ic' => $datum->p_nokp,
                'alamat' => $datum->p_alamat1,
                'poskod' => $datum->p_poskod,
                'bandar' => $datum->p_bandar,
                'daerah_id' => $datum->p_daerah_id,
                'negeri_id' => $datum->p_daerah_id,
                'no_tel' => $datum->p_notel,
                'no_hp' => $datum->p_nohp,
                'jantina' => $datum->p_jantina,
                'tarikh_lahir' => $tarikh_lahir,
                'umur_ketika_mendaftar' => $datum->p_umur,
                'keturunan_id' => $datum->p_keturunan_id,
                'negeri_kelahiran_id' => $datum->p_nkelahiran,
                'nama_sekolah' => $datum->pk_nama_sekolah,
                'tahun_peperiksaan' => $datum->pk_periksa,
                'jumlah_matapelajaran' => $datum->pk_matapelajaran,
                'gred_percubaan_spm_bm' => $datum->ppc_bm,
                'gred_percubaan_spm_ba' => $datum->ppc_ba,
                'gred_percubaan_spm_bi' => $datum->ppc_bi,
                'gred_sebenar_bm' => $datum->pk_bm,
                'gred_sebenar_bi' => $datum->pk_bi,
                'gred_sebenar_pi' => $datum->pk_pi,
                'gred_sebenar_aqs' => $datum->pk_aqs,
                'gred_sebenar_psi' => $datum->pk_bpsi,
                'gred_sebenar_art' => $datum->pk_art,
                'gred_sebenar_ark' => $datum->pk_ark,
                'gred_sebenar_fizik' => $datum->pk_fizik,
                'gred_sebenar_kimia' => $datum->pk_kimia,
                'gred_sebenar_biologi' => $datum->pk_biologi,
                'gred_sebenar_math' => $datum->pk_math,
                'gred_sebenar_math_tambahan' => $datum->pk_math_tambahan,
                'gred_sebenar_akaun' => $datum->pk_akaun,
                'sijil_setaraf' => $datum->pk_setaraf,
                'tahun_sijil_setaraf' => $datum->pk_sthn,
                'nama_sijil_setaraf' => $datum->pk_snama,
                'tahun_stpm' => $datum->pk_stpm_thn,
                'tahun_stam' => $datum->pk_sagama_thn,
                'nama_tilawah' => $datum->pa_tilawah,
                'cita_cita' => $datum->pa_citacita,
                'sebab_memohon' => $datum->pa_sebab,
                'kursus_dihadiri' => $datum->pa_kursus,
                'kokurikulum_sekolah' => $datum->pa_koku,
                'status' => $datum->pa_status,
                // 'img_pelajar' => $datum->img_pelajar,
                'is_deleted' => $datum->is_deleted,
                'deleted_by' => $datum->deleted_by,
                'p_gred' => $datum->p_gred,
                'p_gred_lain' => $datum->p_gred_lain,
                'p_gred_bm' => $datum->p_gred_bm,
                'p_gred_ba' => $datum->p_gred_ba,
                'is_register' => $datum->is_register,
                'gred_akhir' => $datum->gred_akhir,
                'mata_akhir' => $datum->mata_akhir,
                'kedudukan_result' => $datum->kedudukan_result,
                'tarikh_daftar' => $tarikh_daftar,
                'tarikh_berhenti' => $tarikh_berhenti,
                'is_berhenti' => $datum->is_berhenti,
                'sebab_berhenti' => $datum->sebab_berhenti,
                'kod_berhenti' => $datum->kod_berhenti,
                'is_calc' => $datum->is_calc,
                'is_migrate' => $datum->is_migrate,
                'is_gantung' => $datum->is_gantung,
                'next_sem' => $datum->next_sem,
                'jam_kredit' => $datum->j_kredit,
                'jumlah_jam_kredit' => $datum->jumj_kredit,
                'is_tamat' => $datum->is_tamat,
                'is_alumni' => $datum->is_alumni,
                'nama_arab' => $datum->nama_arab,
                'hafazan' => $datum->hafazan,
            ]);
        }
    }
}
