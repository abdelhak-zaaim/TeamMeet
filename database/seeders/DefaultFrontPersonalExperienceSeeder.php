<?php

namespace Database\Seeders;

use App\Models\PersonalExperience;
use Illuminate\Database\Seeder;

class DefaultFrontPersonalExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personalExperiences = [
            [
                'name' => 'Leader + Entrepreneur',
                'is_default' => true,
            ],
            [
                'name' => 'Customer success + Account Management',
                'is_default' => true,
            ],
            [
                'name' => 'Education',
                'is_default' => true,
            ],
            [
                'name' => 'Freelance + Consultant',
                'is_default' => true,
            ],
            [
                'name' => 'Interview Scheduling',
                'is_default' => true,
            ],
            [
                'name' => 'Sales + Marketing',
                'is_default' => true,
            ],
            [
                'name' => 'Other',
                'is_default' => true,
            ],
        ];

        foreach ($personalExperiences as $personalExperience) {
            PersonalExperience::create($personalExperience);
        }
    }
}
