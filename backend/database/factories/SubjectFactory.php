<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Khmer Literature' => "Khmer Literature",
            'Math' => "Math",
            "Biology " => "Biology",
            "Earth Science" => "Earth Science",
            "Civics & Economics" => "Civics & Economics",
            "Physics" => "Physics",
            "Chemistry" => " Chemistry",
            "ICT" => "ICT",
            "Physical Education" => "Physical Education",
            "History" => "History",
            "Geography" => "Geography",
        ];
    }
}
