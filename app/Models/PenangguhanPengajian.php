<?php

namespace App\Models;

use App\Models\Base as Model;

class PenangguhanPengajian extends Model
{
    protected $table = 'penangguhan_pengajian';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_now_id', 'id');
    }
}
