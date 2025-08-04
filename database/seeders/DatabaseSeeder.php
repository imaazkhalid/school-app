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

        // Create students
        Student::factory(200)->create();

        // Manually attach them to ensure we respect the constraints.
        $students = Student::all();
        $sections = Section::all();

        // Loop through students and enroll them in a random section if seats are available.
        $students->each(function ($student) use ($sections) {
            // Find a random section that has available seats.
            $section = $sections->shuffle()->first(function ($s) {
                return $s->seats_available > 0;
            });

            if ($section) {
                // Attach the student to the section with timestamps.
                $section->students()->attach($student->id, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Decrement the available seats count on the section.
                $section->decrement('seats_available');
            }
        });
    }
}
