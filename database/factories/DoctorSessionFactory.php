<?php

namespace Database\Factories;

use App\Models\DoctorSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorSessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DoctorSession::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
