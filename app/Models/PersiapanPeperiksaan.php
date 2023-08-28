<?php

namespace App\Models;

use App\Models\Base as Model;

class PersiapanPeperiksaan extends Model
{
    protected $table = 'persiapan_peperiksaan';

    protected $guarded = ['id'];

    public function persiapanPeperiksaanDetail()
    {
        return $this->HasMany(PersiapanPeperiksaanDetail::class, 'persiapan_peperiksaan_id', 'id');
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Bilik::class, 'lokasi_id', 'id');
    }
}
