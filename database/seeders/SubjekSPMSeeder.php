<?php

namespace Database\Seeders;

use App\Models\SubjekSPM;
use Illuminate\Database\Seeder;

class SubjekSPMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjek_spm = [
            [
                'nama' => 'Bahasa Melayu',
                'minimum_gred' => 'A',
            ],
            [
                'nama' => 'Bahasa Inggeris',
                'minimum_gred' => 'A',
            ],
            [
                'nama' => 'Pendidikan Al-Quran & Sunnah',
                'minimum_gred' => 'A',
            ],
            [
                'nama' => 'Manahij Al-Ulum Al-Islamiah',
                'minimum_gred' => 'A',
            ],
            [
                'nama' => 'Al-Syariah',
                'minimum_gred' => 'A',
            ],
        ];

        foreach ($subjek_spm as $subjek) {
            $order = SubjekSPM::latest('order', 'desc')->first();
            if ($order == null) {
                $order_num = 0;
            } else {
                $order_num = $order->order;
            }
            SubjekSPM::updateOrCreate(
                [
                    'slug' => str_replace(' ', '_', strtolower($subjek['nama'])),
                ],
                [
                    'nama' => $subjek['nama'],
                    'minimum_gred' => $subjek['minimum_gred'],
                    'order' => $order_num + 1,

                ]
            );
        }
    }
}
