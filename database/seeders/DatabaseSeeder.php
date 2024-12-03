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
            'name' => 'admin',
            'username' => 'admin',
            'password' => "admin",
            "user_type" => 1
        ]);

        Student::create([
            'name' => 'Test Data',
            "student_id" => "22-12345",
            "course" => "computer science",
            "year" => 1,
            "section" => "A"
        ]);
    }
}
