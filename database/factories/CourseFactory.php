<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $courseName = $this->faker->word() . ' ' . $this->faker->randomElement(['I', 'II', 'Advanced']);
        return [
            'name' => $courseName,
            'code' => Str::upper(Str::random(3)) . $this->faker->randomNumber(3, true),
            'description' => $this->faker->paragraph(),
        ];
    }
}
