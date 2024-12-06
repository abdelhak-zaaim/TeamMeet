<?php

namespace Database\Seeders;

use App\Models\FrontTestimonial;
use Illuminate\Database\Seeder;

class DefaultFrontTestimonialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inputs = [
            [
                'name' => 'Rashed kabir',
                'designation' => 'Designer',
                'short_description' => 'Having a home based business is a wonderful asset to your life. The problem still stands it comes time advertise your business for a cheap cost. I know you have looked answer everywhere.',
                'profile' => 'front/images/testimonials/testimonial-1.jpg',
                'is_default' => true,
            ],
            [
                'name' => 'Zubayer Hasan',
                'designation' => 'Designer',
                'short_description' => 'Having a home based business is a wonderful asset to your life. The problem still stands it comes time advertise your business for a cheap cost. I know you have looked answer everywhere.',
                'profile' => 'front/images/testimonials/testimonial-2.jpg',
                'is_default' => true,
            ],
        ];

        foreach ($inputs as $input) {
            $profile = $input['profile'];
            unset($input['profile']);
            $frontTestimonial = FrontTestimonial::create($input);
            //            $frontTestimonial->addMediaFromUrl($profile)->toMediaCollection(FrontTestimonial::FRONT_PROFILE,
            //                config('app.media_disc'));
        }
    }
}
