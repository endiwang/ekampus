<?php

namespace Database\Seeders;

use App\Models\SoalanPenilaian;
use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            [
                'question' => 'Pensyarah menerangkan objektif kursus secara terperinci kepada pelajat pada permulaan semester',
                'order' => 1,
            ],
            [
                'question' => 'Pensyarah menerangkan kepada pelajar mengenai silibus kursus pada permulaan semester',
                'order' => 2,
            ],
            [
                'question' => 'Pensyarah menerangkan kepada pelajar tentang sistem pemarkahan dan penilaian secara jelas dan terperinci',
                'order' => 3,
            ],
            [
                'question' => 'Pensyarah membuat ulangan bagi tajuk yang telah diajar pada awal atau akhir proses pengajaran dan pembelajaran',
                'order' => 4,
            ],
            [
                'question' => 'Pensyarah memaklumkan apa yang akan diajar pada kelas berikutnya',
                'order' => 5,
            ],
            [
                'question' => 'Penyampaian pengajaran adalah jelas serta mudah difahami',
                'order' => 6,
            ],
            [
                'question' => 'Pensyarah memberikan tugasan yang bersesuaian dengan kursus yang diajar',
                'order' => 7,
            ],
            [
                'question' => 'Interaksi antara pensyarah dan pelajar adalah aktif dan wujud komunikasi secara dua hala',
                'order' => 8,
            ],
            [
                'question' => 'Kaedah pengajaran yang digunakan oleh pensyarah mampu menarik minat pelajar untuk lebih fokus di dalam kelas',
                'order' => 9,
            ],
            [
                'question' => 'Pensyarah memberikan markah penilaian berterusan secara adil kepada pelajar',
                'order' => 10,
            ],
        ];

        foreach ($questions as $question) {
            SoalanPenilaian::create([
                'description' => $question['question'],
                'order' => $question['order'],
            ]);

        }
    }
}
