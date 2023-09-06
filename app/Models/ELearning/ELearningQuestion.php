<?php

namespace App\Models\ELearning;

use App\Models\Base as Model;

class ELearningQuestion extends Model
{
    protected $guarded = ['id'];

    public function questionType()
    {
        return $this->belongsTo(ELearningQuestionType::class, 'question_type_id', 'id');
    }

    public function questionOptions()
    {
        return $this->hasMany(ELearningQuestionOption::class, 'id', 'question_id');
    }
}
