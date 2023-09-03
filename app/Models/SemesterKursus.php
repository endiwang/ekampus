<?php

namespace App\Models;

use App\Models\Base as Model;

class SemesterKursus extends Model
{
    protected $table = 'semester_kursus';
    protected $guarded = ['id'];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semster_id', 'id');
    }
}
