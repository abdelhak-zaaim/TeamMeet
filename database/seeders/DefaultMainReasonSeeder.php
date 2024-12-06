<?php

namespace Database\Seeders;

use App\Models\MainReason;
use Illuminate\Database\Seeder;

class DefaultMainReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inputs = [
            [
                'key' => 'main_title',
                'value' => '3 Main Reason to Choose us.',
            ],
            [
                'key' => 'image',
                'value' => 'front/images/schedule-concept.jpg',
            ],
            [
                'key' => 'title_1',
                'value' => 'Register and create your first support portal',
            ],
            [
                'key' => 'description_1',
                'value' => 'It only takes 5 minutes. Set-up is smooth & simple, with fully customisable page design to reflect your brand lorem dummy.',
            ], [
                'key' => 'title_2',
                'value' => 'Manage your dashboard easily',
            ],
            [
                'key' => 'description_2',
                'value' => 'It only takes 5 minutes. Set-up is smooth & simple, with fully customisable page design to reflect your brand lorem dummy.',
            ], [
                'key' => 'title_3',
                'value' => 'Start giving support',
            ],
            [
                'key' => 'description_3',
                'value' => 'It only takes 5 minutes. Set-up is smooth & simple, with fully customisable page design to reflect your brand lorem dummy.',
            ],
        ];

        foreach ($inputs as $input) {
            MainReason::create($input);
        }
    }
}
