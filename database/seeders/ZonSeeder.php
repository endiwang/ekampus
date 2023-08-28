<?php

namespace Database\Seeders;

use App\Models\Zon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $zons=[
            [
                'name' => 'Zon Tengah',
                'status' => '1',
            ],
            [
                'name' => 'Zon Utara',
                'status' => '1',
            ],
            [
                'name' => 'Zon Timur',
                'status' => '1',
            ],
            [
                'name' => 'Zon Selatan',
                'status' => '1',
            ]
        ];

        foreach ($zons as $zon) {
            Zon::create($zon);
        }


    }
}
