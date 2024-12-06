<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingCredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $stripeSettingExists = Setting::whereKey('stripe_checkbox_btn')->exists();
        if(!$stripeSettingExists)
        {
            Setting::create(['key'=>'stripe_checkbox_btn','value'=> '0']);
        }



        $stripeKeySetting = Setting::whereKey('stripe_key')->exists();
        if(!$stripeKeySetting)
        {
            Setting::create(['key'=>'stripe_key','value'=> '']);
        }


        $stripeSecretSettingExists = Setting::whereKey('stripe_secret')->exists();
        if(!$stripeSecretSettingExists)
        {
            Setting::create(['key'=>'stripe_secret','value'=> '']);
        }




        $paypalSettingExists = Setting::whereKey('paypal_checkbox_btn')->exists();
        if(!$paypalSettingExists)
        {
            Setting::create(['key'=>'paypal_checkbox_btn','value'=> '0']);
        }



        $paypalKeySetting = Setting::whereKey('paypal_client_id')->exists();
        if(!$paypalKeySetting)
        {
            Setting::create(['key'=>'paypal_client_id','value'=> '']);
        }


        $paypalSecretSettingExists = Setting::whereKey('paypal_secret')->exists();
        if(!$paypalSecretSettingExists)
        {
            Setting::create(['key'=>'paypal_secret','value'=> '']);
        }


        $paypalEnvExists = Setting::whereKey('paypal_mode')->exists();
        if(!$paypalEnvExists)
        {
            Setting::create(['key'=>'paypal_mode','value'=> '']);
        }
    }
}
