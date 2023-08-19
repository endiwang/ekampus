<?php

namespace App\Models;


use App\Models\Base as Model;

class TetapanKeluarMasuk extends Model
{


    protected $table = 'tetapan_keluar_masuk';

    protected $guarded = ['id'];

    public function hari()
    {
        return $this->belongsTo(Hari::class, 'hari_id', 'id');
    }
}
