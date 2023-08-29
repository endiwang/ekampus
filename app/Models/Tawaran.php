<?php

namespace App\Models;

use App\Models\Base as Model;

class Tawaran extends Model
{
    protected $table = 'tawaran';

    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id', 'id');
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }

    public function pusat_pengajian()
    {
        return $this->belongsTo(PusatPengajian::class, 'pusat_id', 'id');
    }

    public function tawaran_permohonan()
    {
        return $this->hasMany(TawaranPermohonan::class);
    }
}
