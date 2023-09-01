<?php

namespace App\Models;

use App\Models\Base as Model;

class JadualPeperiksaan extends Model
{
    protected $table = 'jadual_peperiksaan';

    protected $guarded = ['id'];

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Bilik::class, 'lokasi', 'id');
    }
}
