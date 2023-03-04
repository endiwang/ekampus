<?php

namespace App\Jobs;

use App\Models\OldDatabase\sis_tblpermohonan_pelajaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Permohonan;
use App\Models\PermohonanKelulusanAkademik;

class MigratePermohonanKelulusanAkademik implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mohon_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mohon_id)
    {
        $this->mohon_id = $mohon_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $temp = Permohonan::where('no_rujukan', $this->mohon_id)->first();
        if($temp != null)
        {
            $data = sis_tblpermohonan_pelajaran::where('mohon_id', $this->mohon_id)->first();
            PermohonanKelulusanAkademik::create([
                'permohonan_id' => $temp->id,
                'type'  => $data->type ?? 'NULL',
                'tahun_pepriksaan' => 'NULL',
                'nama_sijil' => $data->type ?? 'NULL',
                'nama_pepriksaan' => $data->type ?? 'NULL',
                'matapelajaran' => $data->matapelajaran ?? 'NULL',
                'gred' => $data->gred ?? 'NULL',
            ]);
        }

    }
}
