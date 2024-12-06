<?php

namespace Database\Seeders;

use App\Models\FrontCMSSetting;
use Illuminate\Database\Seeder;

class AddFieldsInCMSSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $termConditionHtml = view('fronts.cms.terms_conditions')->render();
        FrontCMSSetting::create(['key' => 'terms_conditions', 'value' => $termConditionHtml]);
        $privacyPolicyHtml = view('fronts.cms.privacy_policy')->render();
        FrontCMSSetting::create(['key' => 'privacy_policy', 'value' => $privacyPolicyHtml]);
    }
}
