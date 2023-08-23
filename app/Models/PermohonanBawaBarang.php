<?php

namespace App\Models;

use App\Models\Base as Model;

class PermohonanBawaBarang extends Model
{
    protected $table = 'permohonan_bawa_barang';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }
}
