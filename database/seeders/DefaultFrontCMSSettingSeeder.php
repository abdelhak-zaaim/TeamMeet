<?php

namespace Database\Seeders;

use App\Models\FrontCMSSetting;
use Illuminate\Database\Seeder;

class DefaultFrontCMSSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $frontImageUrl = [
            'key' => 'front_image',
            'value' => 'front/images/hero-image.png',
        ];

        $path = $frontImageUrl['value'];
        $setting = FrontCMSSetting::create($frontImageUrl);
        FrontCMSSetting::create(['key' => 'title', 'value' => 'Great ticketing system for your customer.']);
        FrontCMSSetting::create(['key' => 'email', 'value' => 'companyinfo@mail.com']);
        FrontCMSSetting::create(['key' => 'phone', 'value' => '761 412 3224']);
        FrontCMSSetting::create(['key' => 'region_code', 'value' => '91']);
        FrontCMSSetting::create([
            'key' => 'address',
            'value' => 'C-303, Atlanta Shopping Mall, Nr. Sudama Chowk, Mota Varachha, Surat, Gujarat, India.',
        ]);
        FrontCMSSetting::create(['key' => 'facebook_url', 'value' => 'https://www.facebook.com']);
        FrontCMSSetting::create(['key' => 'twitter_url', 'value' => 'https://www.twitter.com']);
        FrontCMSSetting::create(['key' => 'instagram_url',
            'value' => 'https://www.instagram.com/infyomtechnologies/?hl=en',
        ]);
        FrontCMSSetting::create([
            'key' => 'description',
            'value' => 'For hassale free event, we are here to help you by creating online ticket.',
        ]);
    }
}
