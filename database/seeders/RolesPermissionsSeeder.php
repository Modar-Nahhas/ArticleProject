<?php

namespace Database\Seeders;

use App\Enum\PermissionsEnum;
use App\Enum\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        $adminRole = Role::query()->firstOrCreate([
            'name' => RolesEnum::Admin->value,
            'guard_name' => 'api',
        ]);
        $editorRole = Role::query()->firstOrCreate([
            'name' => RolesEnum::Editor->value,
            'guard_name' => 'api',
        ]);

        $permissions = enumAsArray(PermissionsEnum::class);

        foreach ($permissions as $permission) {
            Permission::query()->firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }
        $adminRole->syncPermissions(Permission::query()->get());


    }
}
