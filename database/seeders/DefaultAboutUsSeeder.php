<?php

namespace Database\Seeders;

use App\Models\FrontCMSSetting;
use Illuminate\Database\Seeder;

class DefaultAboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inputs = [
            [
                'key' => 'about_us_title',
                'value' => 'The world’s first Conversational Relationship Platform',
            ],
            [
                'key' => 'about_us_description',
                'value' => view('fronts.about_us.about_us_description')->render(),
            ],
        ];

        foreach ($inputs as $input) {
            FrontCMSSetting::create($input);
        }
    }
}
