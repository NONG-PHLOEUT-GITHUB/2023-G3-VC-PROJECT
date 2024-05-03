<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'age' => $age,
            'phone_number' => fake()->phoneNumber(),
            'is_class_coordinator' => 'false',
            'email' => fake()->unique()->safeEmail(),
            'address' => $address,
            'role' => 3,
            'email_verified_at' => now(),
            'password' => 'admin1234',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
