<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class KaunselingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedAccessControl();
    }

    private function seedAccessControl()
    {
        $role = Role::updateOrCreate([
            'name' => 'Kaunseling',
        ], [
            'display_name' => 'Kaunseling',
            'type' => 'category',
            // 'parent_category' => null,
        ]);

        $pelajar = Role::updateOrCreate([
            'name' => 'pelajar',
        ], [
            'display_name' => 'Pelajar',
            'type' => 'category',
            // 'parent_category' => null,
        ]);

        $permissions = [
            'view-kaunseling',
            'create-kaunseling',
            'update-kaunseling',
            'delete-kaunseling',
        ];

        foreach ($permissions as $key => $value) {
            $permission = Permission::updateOrCreate([
                'name' => $value,
            ]);

            if (! $role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
            }

            if (! $pelajar->hasPermissionTo($permission)) {
                $pelajar->givePermissionTo($permission);
            }
        }

        User::query()
            ->where('is_student', true)
            ->where('is_staff', false)
            ->where('is_berhenti', false)
            ->where('is_alumni', false)
            ->get()
            ->each(function ($user) {
                if (! $user->hasRole('pelajar')) {
                    $user->assignRole('pelajar');
                }
            });
    }
}
