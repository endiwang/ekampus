<?php

namespace App\Models;

use App\Models\Base as Model;

class PersiapanPeperiksaanDetail extends Model
{
    protected $guarded = ['id'];

    public function persiapanPeperiksaan()
    {
        return $this->belongsTo(PersiapanPeperiksaan::class, 'persiapan_peperiksaan_id', 'id');
    }
}
