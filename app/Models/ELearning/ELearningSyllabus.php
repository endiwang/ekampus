<?php

namespace App\Models\ELearning;

use App\Models\Base as Model;
use App\Models\Kursus;
use App\Models\Subjek;
use App\Models\User;

class ELearningSyllabus extends Model
{
    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id', 'id');
    }

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
