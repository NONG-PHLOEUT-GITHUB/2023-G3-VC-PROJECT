<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GuardianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateOfBirth = fake()->date();
        $address = fake()->streetAddress() . ', ' . fake()->streetName() . ', ' . fake()->citySuffix() . ': ' . fake()->citySuffix();

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'date_of_birth' => $dateOfBirth,
            'chat_id' => fake()->randomElement(['5220313063', '1087047347']),
            'phone_number' => fake()->phoneNumber(),
            'address' => $address
        ];
    }
}
