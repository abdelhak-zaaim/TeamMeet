<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Artisan::call('db:seed', ['--class' => 'AddCaptchaToSuperAdminSetting', '--force' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $reCaptcha = Setting::whereKey('enable_google_recaptcha')->exists();
        if ($reCaptcha) {
            Setting::where('key', 'enable_google_recaptcha')->delete();
            Setting::where('key', 'google_captcha_key')->delete();
            Setting::where('key', 'google_captcha_secret')->delete();
        }
    }
};
