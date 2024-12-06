<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AddIsSuperAdminDefaultFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        if ($user) {
            $user->update(['is_super_admin' => true]);
        }
    }
}
