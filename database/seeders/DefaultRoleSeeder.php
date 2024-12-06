<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DefaultRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'is_default' => true,
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'is_default' => true,
            ],
        ];

        foreach ($roles as $role) {
            $role = Role::create($role);
        }

        /** @var Role $adminRole */
        $adminRole = Role::whereName('admin')->first();

        /** @var User $user */
        $user = User::whereEmail('admin@infycal.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
