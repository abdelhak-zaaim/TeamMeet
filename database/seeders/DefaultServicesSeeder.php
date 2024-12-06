<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class DefaultServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inputs = [
            [
                'key' => 'main_title',
                'value' => 'Use deski to drive growth at your business.',
            ],
            [
                'key' => 'service_image_1',
                'value' => 'front/images/smart-popups.png',
            ],
            [
                'key' => 'service_image_2',
                'value' => 'front/images/embeded-forms.png',
            ],
            [
                'key' => 'service_image_3',
                'value' => 'front/images/autoresponder.png',
            ],
            [
                'key' => 'service_title_1',
                'value' => 'Smart popups',
            ],
            [
                'key' => 'service_title_2',
                'value' => 'Embeded Forms',
            ],
            [
                'key' => 'service_title_3',
                'value' => 'Autoresponder',
            ],
            [
                'key' => 'service_description_1',
                'value' => 'Create customized popups and show the right message at the right time. lorem dummy.',
            ],
            [
                'key' => 'service_description_2',
                'value' => 'Collect website leads with embedded forms and integrate easily.',
            ],
            [
                'key' => 'service_description_3',
                'value' => 'Send welcome email to your new subscribers with a code.',
            ],
        ];

        foreach ($inputs as $input) {
            Service::create($input);
        }
    }
}
