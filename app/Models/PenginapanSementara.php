<?php

namespace App\Models;

use App\Models\Base as Model;

class PenginapanSementara extends Model
{
    protected $table = 'penginapan_sementara';

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'program_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

}
