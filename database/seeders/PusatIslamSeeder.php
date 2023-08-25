<?php

namespace Database\Seeders;

use App\Models\Lookup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PusatIslamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedAccessControl();
        $this->seedData();
    }

    private function seedAccessControl()
    {
        $role = Role::updateOrCreate([
            'name' => 'Pusat Islam',
        ], [
            'display_name' => 'Pusat Islam',
            'type' => 'category',
        ]);

        $permissions = [
            'view-pi-aktiviti',
            'create-pi-aktiviti',
            'update-pi-aktiviti',
            'delete-pi-aktiviti',

            'view-pi-jadual-tugasan',
            'create-pi-jadual-tugasan',
            'update-pi-jadual-tugasan',
            'delete-pi-jadual-tugasan',

            'view-pi-kelas-orang-awam',
            'create-pi-kelas-orang-awam',
            'update-pi-kelas-orang-awam',
            'delete-pi-kelas-orang-awam',

            'view-pi-peserta-kelas-orang-awam',
            'create-pi-peserta-kelas-orang-awam',
            'update-pi-peserta-kelas-orang-awam',
            'delete-pi-peserta-kelas-orang-awam',

            'view-pi-rekod-kehadiran',
            'create-pi-rekod-kehadiran',
            'update-pi-rekod-kehadiran',
            'delete-pi-rekod-kehadiran',

            'view-pi-surat-rasmi',
            'create-pi-surat-rasmi',
            'update-pi-surat-rasmi',
            'delete-pi-surat-rasmi',
        ];

        foreach ($permissions as $key => $value) {
            $permission = Permission::updateOrCreate([
                'name' => $value,
            ]);

            if (! $role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
            }
        }
    }

    private function seedData()
    {
        foreach ($this->data() as $key => $value) {
            Lookup::updateOrCreate([
                'category' => Lookup::CATEGORY_PUSAT_ISLAM,
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
                'name' => 'Senarai Solat Wajib',
                'description' => 'Senarai solat wajib.',
                'key' => 'pusat-islam.senarai-solat-wajib',
                'values' => [
                    'Subuh',
                    'Zohor',
                    'Asar',
                    'Maghrib',
                    'Isyak',
                ],
            ],
        ];
    }
}
