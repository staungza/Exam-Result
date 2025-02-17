<?php

namespace Database\Factories;

use App\Models\Region;
use App\Models\Township;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'roll_no' => $this->faker->bothify('??-####'),
            'student_name' => $this->faker->name,
            'father_name' => $this->faker->name,
            'major' => $this->faker->word,
            'region_id' => Region::query()->inRandomOrder()->first()->id, 
            'township_id' => Township::query()->inRandomOrder()->first()->id, 
            'date_of_birth' => $this->faker->date('Y-m-d', '2000-01-01'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
