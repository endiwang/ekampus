<?php

namespace App\Jobs;

use App\Models\Konvo;
use App\Models\KonvoPelajar;
use App\Models\OldDatabase\sis_tblkonvo_mohon;
use App\Models\Pelajar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MigrateKonvoPelajar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $konvo_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($konvo_id)
    {
        $this->konvo_id = $konvo_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $datum = sis_tblkonvo_mohon::where('konvo_detid', $this->konvo_id)->first();
        $konvo = Konvo::where('konvo_id_old', $datum->konvo_id)->first();
        $pelajar = Pelajar::where('pelajar_id_old', $datum->pelajar_id)->first();
        if ($pelajar == null) {
            $pelajar_id = null;
        } else {
            $pelajar_id = $pelajar->id;
        }
        KonvoPelajar::create([
            'konvo_id' => $konvo->id,
            'kursus_id' => $datum->kursus_id,
            'pelajar_id' => $pelajar_id,
            'type' => $datum->ttype,
            'catatan' => $datum->catatan,
            'kehadiran' => $datum->kehadiran,
            'saiz_kopiah' => $datum->saizkopiah,
            'create_by' => $datum->create_by,
            'created_at' => $datum->create_dt,
            'update_by' => $datum->update_by,
            'updated_at' => $datum->update_dt,
        ]);
    }
}
