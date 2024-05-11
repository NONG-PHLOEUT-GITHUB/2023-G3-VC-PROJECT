<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Attendance;
use App\Models\Comment;
use App\Models\Guardian;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Guardian::factory(20)->create();
        User::factory()->state(['role' => 1])->create(); // Create 1 record with role 1
        User::factory()->count(5)->state(['role' => 2])->create(); // Create 40 records with role 2
        User::factory()->count(20)->state(['role' => 3])->create(); // Create 59 records with role 3

        Attendance::factory(20)->create();
        Comment::factory(10)->create();
        $subjects = [
            'Khmer Literature',
            'Math',
            'Biology',
            'Earth Science',
            'Civics & Economics',
            'Physics',
            'Chemistry',
            'ICT',
            'Physical Education',
            'History',
            'Geography'
        ];

        foreach ($subjects as $id => $subject) {
            $code = substr(str_replace(' ', '', $subject), 0, 2) . ($id + 1); // Take first two letters of subject name and append ID
            Subject::create([
                'id' => $id + 1,
                'subject_name' => $subject,
                'subject_code' => strtoupper($code), // Convert code to uppercase
            ]);
        }
    }
}
