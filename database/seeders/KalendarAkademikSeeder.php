<?php

namespace Database\Seeders;

use App\Models\AktivitiKalendarAkademik;
use App\Models\KalendarAkademik;
use Illuminate\Database\Seeder;

class KalendarAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //create calendar akademik
        $akademik_datas = [
            ['name' => 'Sesi 2023/2024', 'program_id' => 1],
            ['name' => 'Sesi 2023/2024', 'program_id' => 2],
            ['name' => 'Sesi 2023/2024', 'program_id' => 3],
        ];

        $academic_activities = [
            ['aktiviti' => 'Kuliah Semester', 'start_date' => '2023-04-23', 'end_date' => '2023-07-15', 'duration' => '4'],
            ['aktiviti' => 'Hari Guru', 'start_date' => '2023-05-05', 'end_date' => '2023-05-05', 'duration' => '1'],
            ['aktiviti' => 'Peperiksaan Tengah Semester', 'start_date' => '2023-05-10', 'end_date' => '2023-05-20', 'duration' => '1'],
            ['aktiviti' => 'Peperiksaan Semester', 'start_date' => '2023-07-23', 'end_date' => '2023-08-12', 'duration' => '1'],
        ];

        //create aktivit kalendar akademik
        foreach ($akademik_datas as $data) {
            $kalendar = KalendarAkademik::create([
                'name' => $data['name'],
                'program_id' => $data['program_id'],
            ]);

            foreach ($academic_activities as $activity) {
                AktivitiKalendarAkademik::create([
                    'kalendar_akademik_id' => $kalendar->id,
                    'aktiviti' => $activity['aktiviti'],
                    'start_date' => $activity['start_date'],
                    'end_date' => $activity['end_date'],
                    'duration' => $activity['duration'],
                ]);
            }
        }

    }
}
