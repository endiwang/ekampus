<?php

namespace Database\Seeders;

use App\Models\Hari;
use Illuminate\Database\Seeder;

class HariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $haris = [
            'Ahad',
            'Isnin',
            'Selasa',
            'Rabu',
            'Khamis',
            'Jumaat',
            'Sabtu',
        ];

        //insert into subjek table
        foreach ($haris as $hari) {
            Hari::create([
                'nama' => $hari,
            ]);

        }
    }
}
