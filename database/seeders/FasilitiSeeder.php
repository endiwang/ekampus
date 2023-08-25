<?php

namespace Database\Seeders;

use App\Models\Pentadbiran\Fasiliti;
use Illuminate\Database\Seeder;

class FasilitiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['jenis' => 1, 'kategori' => 'Dewan Muktamar', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 1, 'kategori' => 'Dewan Maktabah', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 1, 'kategori' => 'Dewan Muslim', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 1, 'kategori' => 'Dewan Syura', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 1, 'kategori' => 'Auditorium', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 1, 'kategori' => 'Bilik VIP', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 1, 'kategori' => 'Anjung', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 2, 'kategori' => 'Kerusi (VIP/Bankuet (berlengan/biasa)/Flip Chair)', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 2, 'kategori' => 'Meja', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 2, 'kategori' => 'Mikrofon', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 2, 'kategori' => 'PA System', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 2, 'kategori' => 'Projektor', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 2, 'kategori' => 'Laptop', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 2, 'kategori' => 'Rostrum', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 2, 'kategori' => 'Kerusi VIP', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
            ['jenis' => 2, 'kategori' => 'Coffee table', 'kuantiti' => 1, 'status_penggunaan' => 2, 'pengguna' => 'Admin', 'tarikh' => '2023-08-01', 'masa' => '20:15:00'],
        ];

        foreach ($datas as $data) {
            $insert = Fasiliti::create([
                'jenis' => $data['jenis'],
                'kategori' => $data['kategori'],
                'kuantiti' => $data['kuantiti'],
                'status_penggunaan' => $data['status_penggunaan'],
                'pengguna' => $data['pengguna'],
                'tarikh' => $data['tarikh'],
                'masa' => $data['masa'],
                'status' => 1,
            ]);

        }

    }
}
