<?php

namespace App\Jobs;

use App\Models\OldDatabase\sis_tblpermohonan_penjaga;
use App\Models\Permohonan;
use App\Models\PermohonanPenjaga;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MigratePermohonanPenjaga implements ShouldQueue
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
        $data = sis_tblpermohonan_penjaga::where('mohon_id', $this->mohon_id)->first();

        if ($temp != null) {
            if ($data->p_pertalian == 3) {
                PermohonanPenjaga::create([
                    'permohonan_id' => $temp->id,
                    'nama_bapa' => $data->p_nama,
                    'alamat_bapa' => $data->p_alamat,
                    'poskod_bapa' => $data->p_poskod,
                    'no_tel_bapa' => $data->p_notel,
                    'no_ic_bapa' => $data->p_nokp,
                    'pekerjaan_bapa' => $data->p_pekerjaan,
                    'pendapatan_bapa' => $data->p_pendapatan,
                ]);
            } elseif ($data->p_pertalian == 4) {
                PermohonanPenjaga::create([
                    'permohonan_id' => $temp->id,
                    'nama_ibu' => $data->p_nama,
                    'alamat_ibu' => $data->p_alamat,
                    'poskod_ibu' => $data->p_poskod,
                    'no_tel_ibu' => $data->p_notel,
                    'no_ic_ibu' => $data->p_nokp,
                    'pekerjaan_ibu' => $data->p_pekerjaan,
                    'pendapatan_ibu' => $data->p_pendapatan,
                ]);

            } else {
                PermohonanPenjaga::create([
                    'permohonan_id' => $temp->id,
                    'nama_penjaga' => $data->p_nama,
                    'alamat_penjaga' => $data->p_alamat,
                    'poskod_penjaga' => $data->p_poskod,
                    'no_tel_penjaga' => $data->p_notel,
                    'no_ic_penjaga' => $data->p_nokp,
                    'pekerjaan_penjaga' => $data->p_pekerjaan,
                    'pendapatan_penjaga' => $data->p_pendapatan,
                    'pertalian_penjaga' => $data->pertalian_penjaga,
                ]);
            }
        }

    }
}
