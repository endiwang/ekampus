<?php

namespace Database\Seeders;

use App\Models\SoalanPenilaianRating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratings = [
            ['description' => 'Sangat Baik (SB)', 'score' => 5],
            ['description' => 'Baik (B)', 'score' => 4],
            ['description' => 'Sederhana (S)', 'score' => 3],
            ['description' => 'Tidak Memuaskan (TM)', 'score' => 2],
            ['description' => 'Sangat Tidak Memuaskan (STM)', 'score' => 1],
        ];

        foreach($ratings as $rating)
        {
            SoalanPenilaianRating::create([
                'description'   => $rating['description'],
                'order'         => $rating['score']
            ]);

        }
    }
}
