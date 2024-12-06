<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@infycal.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
            'domain_url' => 'infycal',
            'timezone' => '160',
            'step' => '3',
        ]);
    }
}
