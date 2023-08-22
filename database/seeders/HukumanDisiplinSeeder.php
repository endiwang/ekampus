<?php

namespace Database\Seeders;

use App\Models\HukumanDisiplin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HukumanDisiplinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hukuman = [
            'Amaran',
            'Rujukan Kaunseling',
            'Khidmat Komuniti',
            'Rampas/Sita',
            'Ganti Rugi',
            'Denda',
            'Surat Tunjuk Sebab',
        ];

        //insert into subjek table
        foreach ($hukuman as $datum) {
            HukumanDisiplin::create([
                'hukuman' => $datum,
            ]);

        }
    }
}
