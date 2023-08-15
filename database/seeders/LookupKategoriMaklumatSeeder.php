<?php

namespace Database\Seeders;

use App\Models\Lookup\LookupKategoriMaklumat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LookupKategoriMaklumatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'nama'        => 'Panduan Penubuhan Lembaga Darul Quran',
                'status'      => 1,
            ],
            [
                'nama'        => 'Senarai Ahli Lembaga Darul Quran',
                'status'      => 1,
            ],
            [
                'nama'        => 'Minit-minit Mesyuarat Lembaga Darul Quran',
                'status'      => 1,
            ],
            [
                'nama'        => 'Maklum balas Minit Mesyuarat Lembaga Darul Quran',
                'status'      => 1,
            ],
            [
                'nama'        => 'Dokumen Memorandum Perjanjian (MoU/MoA/Nota Kerjasama)',
                'status'      => 1,
            ],
            [
                'nama'        => 'Sistem Pengurusan MS ISO dan Manual Kualiti ',
                'status'      => 1,
            ],
            [
                'nama'        => 'Lain - lain',
                'status'      => 1,
            ],
        ];

        foreach ($datas as $data)
        {      
            LookupKategoriMaklumat::create([
                'nama'   => $data['nama'],
                'status' => $data['status']
            ]); 
        }
    }
}
