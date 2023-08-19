<?php

namespace App\Models;

use App\Models\Base as Model;

class Clo extends Model
{
    protected $guarded = ['id'];

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'program_pengajian_id', 'id');
    }
}
