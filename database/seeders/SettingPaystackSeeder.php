<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingPaystackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(['key' => 'paystack_checkbox_btn', 'value' => 0]);
        Setting::updateOrCreate(['key' => 'paystack_key', 'value' => null]);
        Setting::updateOrCreate(['key' => 'paystack_secret', 'value' => null]);
    }
}
