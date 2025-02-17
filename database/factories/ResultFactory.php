<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Result;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Result>
 */
class ResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $student = Student::query()
            ->whereDoesntHave('results')  // Ensure the student doesn't already have a result
            ->inRandomOrder()
            ->first();

        if (!$student) {
            throw new \Exception("No students found for the result factory.");
        }
        return [
            'roll_no' => $student->roll_no,
            'student_name' => $student->student_name,
            'myanmar' => $this->faker->numberBetween(0, 100),
            'english' => $this->faker->numberBetween(0, 100),
            'mathematics' => $this->faker->numberBetween(0, 100),
            'chemistry' => $this->faker->numberBetween(0, 100),
            'physics' => $this->faker->numberBetween(0, 100),
            'biological' => $this->faker->numberBetween(0, 100),
            'region_id' => $student->region_id, 
            'township_id' => $student->township_id, 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
