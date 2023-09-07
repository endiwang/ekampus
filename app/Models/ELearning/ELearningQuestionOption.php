<?php

namespace App\Models\ELearning;

use App\Models\Base as Model;

class ELearningQuestionOption extends Model
{
    protected $guarded = ['id'];

    public function question()
    {
        return $this->belongsTo(ELearningQuestion::class, 'question_id', 'id');
    }
}
