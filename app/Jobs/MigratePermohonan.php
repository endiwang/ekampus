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
        $data = sis_tblpermohonan::take(100)->where('migrate_status', NULL)->get();

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
            ]);

            sis_tblpermohonan::where('mohon_id', $datum->mohon_id)
                ->update(['migrate_status' => 1]);
        }
    }
}
