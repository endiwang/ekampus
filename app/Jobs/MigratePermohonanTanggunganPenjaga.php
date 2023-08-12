<?php

namespace App\Jobs;

use App\Models\OldDatabase\sis_tblpermohonan_tanggung;
use App\Models\Permohonan;
use App\Models\PermohonanTanggunganPenjaga;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MigratePermohonanTanggunganPenjaga implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mohon_tid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mohon_tid)
    {
        $this->mohon_tid = $mohon_tid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = sis_tblpermohonan_tanggung::where('mohon_tid', $this->mohon_tid)->first();
        $temp = Permohonan::where('no_rujukan', $data->mohon_id)->first();
        if ($temp != null) {
            PermohonanTanggunganPenjaga::create([
                'permohonan_id' => $temp->id,
                'nama' => $data->tid_nama ?? 'NULL',
                'institusi' => $data->tid_sekolah ?? 'NULL',
                'umur' => $data->tid_umur ?? 'NULL',
            ]);
        }

    }
}
