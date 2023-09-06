<?php

namespace Database\Seeders;

use App\Models\ELearning\ELearningQuestionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ELearningQuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questionTypes = [
            [
                'name' => 'multiple_choice_single_answer',
            ],
            [
                'name' => 'multiple_choice_multiple_answer',
            ],
            [
                'name' => 'fill_the_blank',
            ]
        ];

        foreach($questionTypes as $type)
        {
            ELearningQuestionType::create($type);
        }
    }
}
