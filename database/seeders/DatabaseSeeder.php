<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'first_name' => 'Test',
            'last_name' => 'Me',
            'middle_name' => 'User',
            'email' => 'test@example.com',
        ]);

        Student::create([
            'first_name' => 'Test',
            'last_name' => 'Sample',
            'middle_name' => 'Data',
            "student_id" => "22-12345",
            "course" => "computer science",
            "year" => 1,
            "section" => "A"
        ]);
    }
}
