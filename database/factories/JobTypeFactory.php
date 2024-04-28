<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobType>
 */
class JobTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $job_type = ['part_time', 'full_time', 'remote', 'freelancer'];

        return [
            'name' => $job_type[rand(0, 3)],
            'status' => rand(0, 1),
        ];
    }
}
