<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            CourseSeeder::class,
            YearSeeder::class,
            UserSeeder::class,
            QueueSeeder::class,
            ProfessorReviewSeeder::class,
            TimeslotSeeder::class,
            FeedbackSeeder::class,
        ]);

    }
}
