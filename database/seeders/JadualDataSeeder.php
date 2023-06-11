<?php

namespace Database\Seeders;

use App\Models\Subjek;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadualDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //base data used for jadual waktu
        $subjects = [
            ['name' => 'Rehat'],
        ];

        //insert into subjek table
        foreach($subjects as $subject)
        {
            Subjek::create([
                'nama'      => $subject['name'],
                'status'    => 0,
                'kredit'    => 0,
                'is_alquran'=> 0
            ]);

        }
    }
}
