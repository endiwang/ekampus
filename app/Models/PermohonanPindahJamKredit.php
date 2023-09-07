<?php

namespace App\Models;

use App\Models\Base as Model;

class PermohonanPindahJamKredit extends Model
{
    protected $table = 'permohonan_pindah_jam_credit';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id', 'id');
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }

    public function syukbah()
    {
        return $this->belongsTo(Syukbah::class, 'syukbah_id', 'id');
    }

}