<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'subtitle' => fake()->sentence(),
            'body' => fake()->sentence(),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'teacher_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
