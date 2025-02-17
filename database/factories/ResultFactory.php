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
        // $student = Student::query()
        //     ->whereDoesntHave('results')  
        //     ->inRandomOrder()
        //     ->first();

        $existingRollNos = Result::query()->pluck('roll_no')->toArray();

        // Fetch a random student who doesn't have a result (i.e., their roll_no is not in the results table)
        $student = Student::query()
            ->whereNotIn('roll_no', $existingRollNos)  // Exclude roll_no values that already exist in results
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
