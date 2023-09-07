<?php

namespace App\Models\ELearning;

use App\Models\Base as Model;
use App\Models\Kursus;
use App\Models\Semester;
use App\Models\Staff;

class ELearningTimetable extends Model
{
    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id', 'id');
    }

    public function kandungan()
    {
        return $this->belongsTo(ELearningSyllabus::class, 'syllabus_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
