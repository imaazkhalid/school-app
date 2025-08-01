<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $capacity = $this->faker->numberBetween(15, 50);
        return [
            'course_id' => Course::factory(), // This creates a new Course
            'teacher_id' => Teacher::factory(), // This creates a new Teacher
            'schedule' => $this->faker->dayOfWeek() . 's, ' . $this->faker->time('H:i') . ' - ' . $this->faker->time('H:i'),
            'capacity' => $capacity,
            'seats_available' => $capacity,
        ];
    }
}
