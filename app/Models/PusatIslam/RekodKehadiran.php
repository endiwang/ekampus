<?php

namespace App\Models\PusatIslam;

use App\Models\Base as Model;

class RekodKehadiran extends Model
{
    protected $table = 'pi_rekod_kehadiran';

    public function kelas()
    {
        return $this->belongsTo(KelasOrangAwam::class);
    }

    public function peserta()
    {
        return $this->belongsTo(PesertaKelasOrangAwam::class, 'peserta_kelas_orang_awam_id');
    }
}
