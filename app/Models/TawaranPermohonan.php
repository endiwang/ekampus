<?php

namespace App\Models;


use App\Models\Base as Model;

class TawaranPermohonan extends Model
{


    protected $table = 'tawaran_pemohon';

    protected $guarded = ['id'];

    public function pemohon()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }
}
