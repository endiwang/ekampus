<?php

namespace App\Models;

use App\Models\Base as Model;

class PermohonanKeluarMasuk extends Model
{
    protected $table = 'permohonan_keluar_masuk';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pemohon_pelajar_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pemohon_user_id', 'id');
    }
}
