<?php

namespace Database\Seeders;

use App\Enum\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $admin */
        $admin = User::query()->firstOrCreate([
            'name' => 'admin'
        ], [
            'password' => '12345'
        ]);

        $admin->syncRoles(RolesEnum::Admin->value);
    }
}
