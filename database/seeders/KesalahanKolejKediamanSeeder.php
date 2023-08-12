<?php

namespace Database\Seeders;

use App\Models\KesalahanKolejKediaman;
use Illuminate\Database\Seeder;

class KesalahanKolejKediamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kesalahan = [
            'Bilik Tidak Kemas',
            'Bilik Bersepah & Kotor',
            'Mengalihkan Aset / Perabot',
            'Suis Lampu/Kipas/Plug 3 Pin Tidak Ditutup',
            'Jemur Pakaian Di Tempat Larangan',
        ];

        //insert into subjek table
        foreach ($kesalahan as $data) {
            KesalahanKolejKediaman::create([
                'nama_kesalahan' => $data,
            ]);

        }
    }
}
