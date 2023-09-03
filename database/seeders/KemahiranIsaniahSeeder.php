<?php

namespace Database\Seeders;

use App\Models\Lookup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class KemahiranIsaniahSeeder extends Seeder
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
            'name' => 'Kemahiran Insaniah',
        ], [
            'display_name' => 'Kemahiran Insaniah',
            'type' => 'category',
        ]);

        $permissions = [
            'view-ki-pilihan-raya',
            'create-ki-pilihan-raya',
            'update-ki-pilihan-raya',
            'delete-ki-pilihan-raya',

            'view-ki-penamaan-calon',
            'create-ki-penamaan-calon',
            'update-ki-penamaan-calon',
            'delete-ki-penamaan-calon',
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
                'category' => Lookup::CATEGORY_KEMAHIRAN_INSANIAH,
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
        return [];
    }
}
