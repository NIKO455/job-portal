<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPost>
 */
class JobPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->name();
        return [
            "title" => $title,
            "slug" => Str::slug($title),
            "user_id" => 1,
            "status" => 1,
            "category_id" => rand(1, 5),
            "job_type_id" => rand(1, 3),
            "vacancy" => rand(1, 10),
            "salary" => rand(),
            "location" => fake()->country(),
            "description" => fake()->text(),
            "experience" => "3 Years",
            "company_name" => fake()->name(),
            "is_featured" => rand(0, 1)
        ];
    }
}
