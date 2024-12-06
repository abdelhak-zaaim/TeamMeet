<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(DefaultUserSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(DefaultRoleSeeder::class);
        $this->call(DefaultFrontPersonalExperienceSeeder::class);
        $this->call(DefaultFrontTestimonialsSeeder::class);
        $this->call(DefaultServicesSeeder::class);
        $this->call(DefaultFrontCMSSettingSeeder::class);
        $this->call(DefaultFaqsSeeder::class);
        $this->call(DefaultMainReasonSeeder::class);
        $this->call(DefaultAboutUsSeeder::class);
        $this->call(DefaultSubscriptionPlanTableSeeder::class);
        $this->call(AddFieldsInCMSSettingSeeder::class);
        $this->call(AddDaysIntoSettingTableSeeder::class);
        $this->call(AddDefaultFieldInSetting::class);
        $this->call(DefaultCountryCode::class);
        $this->call(AddIsSuperAdminDefaultFieldSeeder::class);
    }
}
