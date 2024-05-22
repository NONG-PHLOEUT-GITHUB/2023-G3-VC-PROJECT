<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'profile' => "http://127.0.0.1:8000/images/408632910.JPG",
            'first_name' => "Super",
            'last_name' => "Administrator",
            'gender' => 'female',
            'date_of_birth' => "2012-03-02",
            'age' => "23",
            'phone_number' => "0 94 94 94 08",
            'email' => "admin@example.com",
            'address' => "admin address",
            'role' => "1",
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'),
            'remember_token' => Str::random(10),
        ]);
    }
}
