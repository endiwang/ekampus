<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jabatan_array = [
            [
                'Jabatan Pengajian Sepanjang Hayat',
            ],

        ];

        foreach ($jabatan_array as $data) {
            $jabatan = new Jabatan();
            $jabatan->nama = $data[0];
            $jabatan->status = 1;
            $jabatan->save();
        }
    }
}
