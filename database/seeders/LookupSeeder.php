<?php

namespace Database\Seeders;

use App\Models\Lookup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class LookupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedPermissions();
        $this->seedData();
    }

    private function seedPermissions()
    {
        $permissions = [
            'view-lookup',
            'create-lookup',
            'update-lookup',
            'delete-lookup',
        ];

        foreach ($permissions as $key => $value) {
            Permission::updateOrCreate([
                'name' => $value,
            ]);
        }
    }

    private function seedData()
    {
        foreach ($this->data() as $key => $value) {
            Lookup::updateOrCreate([
                'category' => Lookup::CATEGORY_KAUNSELING,
                'key' => $value['key'],
            ], [
                'name' => $value['name'],
                'description' => $value['description'],
                'values' => $value['values'],
            ]);
        }
    }

    private function data()
    {
        return [
            [
                'name' => 'Jenis-jenis Kes',
                'description' => 'Senarai jenis-jenis kes kaunseling.',
                'key' => 'kaunseling.jenis-kes',
                'values' => [
                    'Kes Keluarga',
                    'Kes Kecurian',
                ],
            ],
            [
                'name' => 'Jenis-jenis Kaunseling',
                'description' => 'Senarai jenis-jenis kaunseling.',
                'key' => 'kaunseling.jenis-kaunseling',
                'values' => [
                    'Kaunseling Individu',
                    'Kaunseling Kumpulan',
                ],
            ],
            [
                'name' => 'Senarai Jenis Pengujian',
                'description' => 'Senarai jenis pengujian.',
                'key' => 'kaunseling.jenis-pengujian',
                'values' => [
                    'Pengujian Psikometrik',
                    'Pengujian Psikologi',
                    'Pengujian Psikometrik dan Psikologi',
                ],
            ],
        ];
    }
}
