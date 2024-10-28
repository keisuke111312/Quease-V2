<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProfessorReview;


class ProfessorReviewSeeder extends Seeder
{
    public function run()
    {
        ProfessorReview::factory()->count(20)->create();
    }
}
