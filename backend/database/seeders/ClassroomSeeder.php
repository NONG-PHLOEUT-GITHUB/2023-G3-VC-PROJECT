<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Classroom::create([
        //     'classroom_name' => '10 A',
        // ]);
        $letters = range('A', 'J'); // This will create letters from A to J

        for ($i = 0; $i < 10; $i++) {
            Classroom::create([
                'classroom_name' => '10 ' . $letters[$i],
            ]);
        }
    }
}
