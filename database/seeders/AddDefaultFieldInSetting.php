<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class AddDefaultFieldInSetting extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create(['key' => 'auto_detect_location_enable', 'value' => '0']);
        Setting::create(['key' => 'google_place_api_key', 'value' => '']);
    }
}
