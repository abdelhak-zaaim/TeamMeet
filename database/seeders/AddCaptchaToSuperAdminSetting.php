<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddCaptchaToSuperAdminSetting extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reCaptcha = Setting::whereKey('enable_google_recaptcha')->exists();
        if (! $reCaptcha) {
            Setting::create([
                'key' => 'enable_google_recaptcha', 'value' => 0,
            ]);
            Setting::create([
                'key' => 'google_captcha_key', 'value' => null,
            ]);
            Setting::create([
                'key' => 'google_captcha_secret', 'value' => null,
            ]);
        }
    }
}
