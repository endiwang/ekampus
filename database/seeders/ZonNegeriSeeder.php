<?php

namespace Database\Seeders;

use App\Models\Zon;
use App\Models\ZonNegeri;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZonNegeriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $zon_negeris=[
            [
                'zon_id' => 1,
                'name' => 'Putrajaya',
                'status' => '1',
            ],
            [
                'zon_id' => 1,
                'name' => 'Kuala Lumpur',
                'status' => '1',
            ],
            [
                'zon_id' => 1,
                'name' => 'Selangor',
                'status' => '1',
            ],
            [
                'zon_id' => 1,
                'name' => 'Perak',
                'status' => '1',
            ],
            [
                'zon_id' => 2,
                'name' => 'Kedah',
                'status' => '1',
            ],
            [
                'zon_id' => 2,
                'name' => 'Pulau Pinang',
                'status' => '1',
            ],
            [
                'zon_id' => 2,
                'name' => 'Perlis',
                'status' => '1',
            ],
            [
                'zon_id' => 3,
                'name' => 'Pahang',
                'status' => '1',
            ],
            [
                'zon_id' => 3,
                'name' => 'Terengganu',
                'status' => '1',
            ],
            [
                'zon_id' => 3,
                'name' => 'Kelantan',
                'status' => '1',
            ],
            [
                'zon_id' => 4,
                'name' => 'Negeri Sembilan',
                'status' => '1',
            ],
            [
                'zon_id' => 4,
                'name' => 'Melaka',
                'status' => '1',
            ],
            [
                'zon_id' => 4,
                'name' => 'Johor Bharu',
                'status' => '1',
            ],
        ];

        foreach ($zon_negeris as $negeri) {
            ZonNegeri::create($negeri);
        }


    }
}
