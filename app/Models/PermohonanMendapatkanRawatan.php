<?php

namespace App\Models;

use App\Models\Base as Model;

class PermohonanMendapatkanRawatan extends Model
{
    protected $table = 'permohonan_mendapatkan_rawatan';

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class, 'penyakit_id', 'id');
    }
}
