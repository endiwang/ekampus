<?php

namespace App\Models;

use App\Models\Base as Model;

class AktivitiPdp extends Model
{
    protected $table = 'aktiviti_pdp';

    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }
}
