<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearSeeder extends Seeder
{
    public function run()
    {
        DB::table('years')->insert([
            ['level' => '1'],  // 1st Year
            ['level' => '2'],  // 2nd Year
            ['level' => '3'],  // 3rd Year
            ['level' => '4'],  // 4th Year
        ]);
    }
}
