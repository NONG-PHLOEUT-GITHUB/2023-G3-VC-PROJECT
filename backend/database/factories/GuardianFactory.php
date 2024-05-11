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
        $age = date_diff(date_create($dateOfBirth), date_create('today'))->y;
        $address = fake()->streetAddress() . ', ' . fake()->streetName() . ', ' . fake()->citySuffix() . ': ' . fake()->citySuffix();

        return [
            'profile' => "http://127.0.0.1:8000/images/408632910.JPG",
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['male', 'female']),
            'date_of_birth' => $dateOfBirth,
            'chatId' => fake()->randomElement(['5220313063', '1087047347']),
            'age' => $age,
            'phone_number' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'address' => $address
        ];
    }
}
