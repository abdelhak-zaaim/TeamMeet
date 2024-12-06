<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create(['key' => 'application_name', 'value' => 'InfyCal']);
        Setting::create(['key' => 'currency', 'value' => 'inr']);

        $logoUrl = [
            'key' => 'logo',
            'value' => 'assets/images/infy-cal-logo.png',
        ];

        $setting = Setting::create($logoUrl);

        $faviconUrl = [
            'key' => 'favicon',
            'value' => 'assets/images/favicon.ico',
        ];

        $setting = Setting::create($faviconUrl);
    }
}
