<?php

namespace App\Models;


use App\Models\Base as Model;

class Permohonan extends Model
{


    protected $table = 'permohonan';

    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id', 'id');
    }

    public function keturunan()
    {
        return $this->belongsTo(Keturunan::class, 'keturunan_id', 'id');
    }

    public function penjaga()
    {
        return $this->hasOne(PermohonanPenjaga::class, 'permohonan_id', 'id');
    }

    public function tanggungan_penjaga()
    {
        return $this->hasMany(PermohonanTanggunganPenjaga::class, 'permohonan_id', 'id');
    }

    public function akademik()
    {
        return $this->hasMany(PermohonanKelulusanAkademik::class, 'permohonan_id', 'id');
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }

    public function pusat_pengajian()
    {
        return $this->belongsTo(PusatPengajian::class, 'pusat_pengajian_id', 'id');
    }

    public function proses_temuduga()
    {
        return $this->belongsTo(Temuduga::class, 'temuduga_id', 'id');
    }

    public function temuduga_markah()
    {
        return $this->hasOne(TemudugaMarkah::class, 'permohonan_id', 'id');
    }

    public function muatnaik_dokumen()
    {
        return $this->hasMany(PermohonanMuatnaikDokumen::class, 'permohonan_id', 'id');
    }
}
