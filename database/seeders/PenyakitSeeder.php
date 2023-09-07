<?php

namespace Database\Seeders;

use App\Models\Penyakit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pemyakit = [
            'Demam',
            'Selsema',
            'Sakit Perut',
            'Sakit Perempuan'
        ];

        //insert into subjek table
        foreach ($pemyakit as $datum) {
            Penyakit::create([
                'nama' => $datum,
            ]);

        }
    }
}
