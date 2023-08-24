<?php

namespace Database\Seeders;

use App\Models\Yuran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YuranSeeder extends Seeder
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
                'Yuran Pendaftaran',
                100,
            ],
            [
                'Yuran Konvokesyen',
                100,
            ],
            [
                'Yuran Peperiksaan',
                100,
            ],
            [
                'Yuran Sijil Tahfiz Malaysia',
                100,
            ],
            [
                'Kutipan Bayaran Balik',
                100,
            ]
        ];

        foreach($yuran_array as $data)
        {
            $yuran = new Yuran;
            $yuran->nama = $data[0];
            $yuran->amaun = $data[1];
            $yuran->status = 1;
            $yuran->save();
        }
    }
}
