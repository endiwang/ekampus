<?php

namespace Database\Seeders;

use App\Models\YuranDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YuranDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $yuran_array = [
            [
                1,
                'Yuran Pendaftaran',
                100,
            ],
            [
                2,
                'Yuran Konvokesyen',
                100,
            ],
            [
                3,
                'Yuran Peperiksaan',
                100,
            ],
            [
                4,
                'Yuran Sijil Tahfiz Malaysia',
                100,
            ],
            [
                5,
                'Kutipan Bayaran Balik',
                100,
            ]
        ];

        foreach($yuran_array as $data)
        {
            $yuran_detail = new YuranDetail;
            $yuran_detail->yuran_id = $data[0];
            $yuran_detail->nama = $data[1];
            $yuran_detail->amaun = $data[2];
            $yuran_detail->save();
        }
    }
}
