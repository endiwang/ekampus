<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            [
                'name'              => 'kakitangan',
                'display_name'      => 'Kakitangan',
                'type'              => 'category',
                'parent_category'   => NULL
            ],
            [
                'name'              => 'pelajar',
                'display_name'      => 'Pelajar',
                'type'              => 'category',
                'parent_category'   => NULL

            ],
            [
                'name'              => 'alumni',
                'display_name'      => 'Alumni',
                'type'              => 'category',
                'parent_category'   => NULL
            ],
            [
                'name'              => 'kontraktor',
                'display_name'      => 'Kontraktor',
                'type'              => 'category',
                'parent_category'   => NULL
            ],
            [
                'name'              => 'pegawai_keselamatan',
                'display_name'      => 'Pegawai Keselamatan',
                'type'              => 'category',
                'parent_category'   => NULL
            ],
            [
                'name'              => 'pensyarah',
                'display_name'      => 'Pensyarah',
                'type'              => 'designation',
                'parent_category'   => 'kakitangan'

            ],
            [
                'name'              => 'pensyarah_jemputan',
                'display_name'      => 'Pensyarah Jemputan',
                'type'              => 'designation',
                'parent_category'   => 'kakitangan'

            ],
            [
                'name'              => 'pensyarah_tasmik',
                'display_name'      => 'Pensyarah Tasmik',
                'type'              => 'designation',
                'parent_category'   => 'kakitangan'
            ],
            [
                'name'              => 'pensyarah_tasmik_jemputan',
                'display_name'      => 'Pensyarah Tasmik Jemputan',
                'type'              => 'designation',
                'parent_category'   => 'kakitangan'
            ],
            [
                'name'              => 'warden',
                'display_name'      => 'Warden',
                'type'              => 'designation',
                'parent_category'   => 'kakitangan'
            ],
            [
                'name'              => 'tutor',
                'display_name'      => 'Tutor',
                'type'              => 'designation',
                'parent_category'   => 'kakitangan'
            ],
        ];

        foreach ($roles as $role)
        {
            if($role['parent_category'] == NULL)
            {
                $parent_category_id = NULL;
            }else {
                $parent_category = Role::where('name', $role['parent_category'])->first();
                $parent_category_id = $parent_category->id;
            }
            Role::updateOrCreate(
                [
                    'name'  => $role['name'],
                ],
                [
                    'display_name'          => $role['display_name'],
                    'type'                  => $role['type'],
                    'parent_category_id'    => $parent_category_id,
                ]
            );
        }

    }
}
