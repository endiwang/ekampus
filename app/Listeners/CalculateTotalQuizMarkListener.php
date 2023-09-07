<?php

namespace App\Listeners;

use App\Events\QuizMarkEvent;
use App\Models\ELearning\ELearningAnswer;
use App\Models\ELearning\ELearningQuestionOption;
use App\Models\ELearning\ELearningStudentMark;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalculateTotalQuizMarkListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\QuizMarkEvent  $event
     * @return void
     */
    public function handle(QuizMarkEvent $event)
    {
        //get all answer for the quiz
        $answers = ELearningAnswer::where('quiz_id', $event->quiz_id)->where('student_id', $event->student_id)->get();

        $total = 0;
        foreach($answers as $answer)
        {
            $data = ELearningQuestionOption::with('question')->find($answer->question_option_id);

            $mark = 0;
            if($data->is_correct == 1)
            {
                if($data->question->question_type_id == 1 || $data->question->question_type_id == 2)
                {
                    $mark = $data->question->mark;
                }
                elseif($data->question->question_type_id == 3)
                {
                    if($answer->answer == $data->name)
                    {
                        $mark = $data->question->mark;
                    }
                }
            }

            $total += $mark; 
        }

        //save total mark in db
        ELearningStudentMark::updateOrCreate([
            'student_id'    => $event->student_id,
            'quiz_id'       => $event->quiz_id, 
            'total_mark'    => $total,
        ]);
    }
}
