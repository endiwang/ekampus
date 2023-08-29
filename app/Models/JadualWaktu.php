<?php

namespace App\Models;

use App\Models\Base as Model;

class JadualWaktu extends Model
{
    protected $table = 'jadual_waktu';

    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function jadualWaktuDetail()
    {
        return $this->HasMany(JadualWaktuDetail::class, 'jadual_waktu_id', 'id');
    }
}
