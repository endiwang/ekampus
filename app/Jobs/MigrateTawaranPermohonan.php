<?php

namespace App\Jobs;

use App\Models\OldDatabase\sis_tbltawaran_mohon;
use App\Models\Permohonan;
use App\Models\Tawaran;
use App\Models\TawaranPermohonan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MigrateTawaranPermohonan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tawaran_tid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tawaran_tid)
    {
        $this->tawaran_tid = $tawaran_tid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $datum = sis_tbltawaran_mohon::where('id',$this->tawaran_tid)->first();
        $tawaran = Tawaran::where('tawaran_id_old',$datum->tawaran_id)->first();
        $permohonan= Permohonan::where('no_rujukan',$datum->mohon_id)->first();
        TawaranPermohonan::create([
            'tawaran_id'        => $tawaran->id,
            'permohonan_id'     => $permohonan == NULL ? NULL : $permohonan->id,
            'surat_tawaran'     => $datum->surat_tawaran,
            'surat_biasiswa'    => $datum->surat_biasiswa,
            'surat_terimaan'    => $datum->surat_terimaan,
            'tarikh_terima'     => $datum->tkh_terima  == '0000-00-00' ? NULL : $datum->tkh_terima,
            'catatan'           => $datum->catatan,
            'is_terima'         => $datum->is_terima,
            'create_by'         => $datum->create_by,
            'update_by'         => $datum->update_by,
            'created_at'        => $datum->create_dt,
            'updated_at'        => $datum->update_dt,
        ]);
    }
}
