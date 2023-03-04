<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\OldDatabase\sis_tblpermohonan;
use App\Models\Permohonan;
use App\Models\Staff;

class MigratePermohonan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = sis_tblpermohonan::take(100)->where('migrate_status', NULL)->with('tarikh')->get();

        foreach($data as $datum)
        {
            if($datum->m_tkh_lahir = '0000-00-00')
            {
                $tarikh_lahir = NULL;
            }else{
                $tarikh_lahir = $datum->m_tkh_lahir;
            }


            if($datum->m_warganegara = 'M')
            {
                $warganegara = 1;
            }else{
                $warganegara = $datum->m_warganegara;
            }

            if($datum->tarikh)
            {
                if(str_contains($datum->tarikh->select_by,'DQ'))
                {
                    $staff_selected = Staff::where('staff_id',$datum->tarikh->select_by)->first();
                    $selected_by = $staff_selected->id;
                }else{
                    $selected_by = NULL;
                }

                if(str_contains($datum->tarikh->tawaran_by,'DQ'))
                {
                    $staff_tawaran = Staff::where('staff_id',$datum->tarikh->tawaran_by)->first();
                    $tawaran_by = $staff_tawaran->id;
                }else{
                    $tawaran_by = NULL;
                }

            }else{
                $selected_by = NULL;
                $tawaran_by = NULL;
            }

            Permohonan::create([
                'no_rujukan' => $datum->mohon_id,
                'kursus_id' => $datum->kursus_id,
                'sesi_id' => $datum->sesi_id,
                'pusat_pengajian_id' => $datum->pusat_id,
                'nama' => $datum->m_nama,
                'email' => $datum->m_email,
                'alamat_tetap' => $datum->m_alamat1,
                'poskod' => $datum->m_poskod,
                'daerah_id' => $datum->m_daerah_id,
                'negeri_id' => $datum->m_negeri_id,
                'no_tel' => $datum->m_notel,
                'jantina' => $datum->m_jantina,
                'no_ic' => $datum->m_nokp,
                'tarikh_lahir' => $tarikh_lahir,
                'negeri_kelahiran_id' => $datum->m_nkelahiran,
                'keturunan_id' => $datum->m_keturunan_id,
                'warganegara' => $warganegara,
                'temuduga' => $datum->m_temuduga,
                'alamat_surat' => $datum->m_alamat1,
                'perakuan' => $datum->m_chk_perakuan,

                'is_submitted' => $datum->tarikh->is_submitted ?? 0,
                'submitted_date' => $datum->tarikh->submit_dt ?? NULL,
                'is_selected' => $datum->tarikh->is_selected ?? 0,
                'selected_date' => $datum->tarikh ? ($datum->tarikh->select_dt == '0000-00-00 00:00:00' ? NULL : $datum->tarikh->select_dt) : NULL,
                'selected_by' => $selected_by,
                'is_interview' => $datum->tarikh->is_interview ?? 0,
                'is_interview_surat' => $datum->tarikh->is_int_surat ?? 0,
                'interview_date' => $datum->tarikh ? ($datum->tarikh->interview_dt == '0000-00-00' ? NULL : $datum->tarikh->interview_dt) : NULL,
                'interview_by' => $datum->tarikh->interview_updby ?? NULL,
                'is_tawaran' => $datum->tarikh->is_tawaran ?? 0,
                'is_tawaran_surat' => $datum->tarikh->is_tawaran_surat ?? 0,
                'tawaran_date' => $datum->tarikh ? ($datum->tarikh->tawaran_dt == '0000-00-00' ? NULL : $datum->tarikh->tawaran_dt) : NULL,
                'tawaran_by' => $tawaran_by,
                'is_terima' => $datum->tarikh->is_terima ?? 0,
                'terima_date' => $datum->tarikh ? ($datum->tarikh->terima_tarikh == '0000-00-00 00:00:00' ? NULL : $datum->tarikh->terima_tarikh) : NULL,

                'is_deleted' => $datum->is_deleted,
            ]);

            sis_tblpermohonan::where('mohon_id', $datum->mohon_id)
                ->update(['migrate_status' => 1]);
        }
    }
}
