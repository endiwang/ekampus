<?php

namespace App\Models\ELearning;

use App\Models\Base as Model;
use App\Models\Kursus;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class ELearningQuiz extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
