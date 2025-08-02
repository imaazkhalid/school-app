<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a single admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('superstrongadminpassword'),
            'role' => 'admin',
        ]);

        // Create some teachers
        // Teacher::factory(5)->create();

        // Create some courses
        // Course::factory(10)->create();

        // Create a bunch of sections, which will automatically create related courses and teachers
        Section::factory(20)->create();

        // Create 50 students
        Student::factory(50)->create();
    }
}
