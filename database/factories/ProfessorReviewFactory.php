<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfessorReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'faculty_id' => $this->faker->numberBetween(7, 10), // Assuming you have user IDs from 1 to 10 for faculty
            'student_id' => $this->faker->numberBetween(1, 6), // Assuming the same for students
            'queue_id' => $this->faker->numberBetween(1, 6), // Adjust according to the existing queue IDs
            'rating' => $this->faker->numberBetween(1, 5), // Assuming a rating system from 1 to 5
            'comment' => 'sample comment', 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
