<?php

namespace App\Models;

use App\Models\Base as Model;

class SemesterSubjek extends Model
{
    protected $table = 'semester_subjek';
    protected $guarded = ['id'];

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }

    public function semesterKursus()
    {
        return $this->belongsTo(SemesterKursus::class, 'semester_kursus_id', 'id');
    }
}
