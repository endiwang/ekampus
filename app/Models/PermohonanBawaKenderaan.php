<?php

namespace App\Models;

use App\Models\Base as Model;

class PermohonanBawaKenderaan extends Model
{

    protected $table = 'permohonan_bawa_kenderaan';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }
}
