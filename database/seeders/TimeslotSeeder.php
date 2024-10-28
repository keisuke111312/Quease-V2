<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimeslotSeeder extends Seeder
{
    public function run()
    {
        $timestamp = Carbon::now();

        DB::table('timeslots')->insert(
            [
                [
                    'user_id' => '7',
                    'day' => 'Monday',
                    'start' => '10:00:00',
                    'end' => '10:15:00',
                    'created_at' => $timestamp->toDateTimeString()

                ],

                [
                    'user_id' => '7',
                    'day' => 'Tuesday',
                    'start' => '13:00:00',
                    'end' => '13:15:00',
                    'created_at' => $timestamp->toDateTimeString()


                ],

                [
                    'user_id' => '7',
                    'day' => 'Wednesday',
                    'start' => '13:00:00',
                    'end' => '13:30:00',
                    'created_at' => $timestamp->toDateTimeString()

                ],
                [
                    'user_id' => '7',
                    'day' => 'Thursday',
                    'start' => '13:00:00',
                    'end' => '13:45:00',
                    'created_at' => $timestamp->toDateTimeString()

                ],
                [
                    'user_id' => '7',
                    'day' => 'Friday',
                    'start' => '13:00:00',
                    'end' => '14:00:00',
                    'created_at' => $timestamp->toDateTimeString()

                ],
                [
                    'user_id' => '8',
                    'day' => 'Monday',
                    'start' => '10:00:00',
                    'end' => '10:15:00',
                    'created_at' => $timestamp->toDateTimeString()

                ],

                [
                    'user_id' => '8',
                    'day' => 'Tuesday',
                    'start' => '13:00:00',
                    'end' => '13:15:00',
                    'created_at' => $timestamp->toDateTimeString()


                ],

                [
                    'user_id' => '8',
                    'day' => 'Wednesday',
                    'start' => '13:00:00',
                    'end' => '13:30:00',
                    'created_at' => $timestamp->toDateTimeString()

                ],
                [
                    'user_id' => '8',
                    'day' => 'Thursday',
                    'start' => '13:00:00',
                    'end' => '13:45:00',
                    'created_at' => $timestamp->toDateTimeString()

                ],
                [
                    'user_id' => '8',
                    'day' => 'Friday',
                    'start' => '13:00:00',
                    'end' => '14:00:00',
                    'created_at' => $timestamp->toDateTimeString()

                ],
                [
                    'user_id' => '9',
                    'day' => 'Monday',
                    'start' => '10:00:00',
                    'end' => '10:15:00',
                    'created_at' => $timestamp->toDateTimeString()

                ],

                [
                    'user_id' => '9',
                    'day' => 'Tuesday',
                    'start' => '13:00:00',
                    'end' => '13:15:00',
                    'created_at' => $timestamp->toDateTimeString()


                ],

                [
                    'user_id' => '9',
                    'day' => 'Wednesday',
                    'start' => '13:00:00',
                    'end' => '13:30:00',
                    'created_at' => $timestamp->toDateTimeString()

                ],
                [
                    'user_id' => '9',
                    'day' => 'Thursday',
                    'start' => '13:00:00',
                    'end' => '13:45:00',
                    'created_at' => $timestamp->toDateTimeString()

                ],
                [
                    'user_id' => '9',
                    'day' => 'Friday',
                    'start' => '13:00:00',
                    'end' => '14:00:00',
                    'created_at' => $timestamp->toDateTimeString()

                ],

            ]
        );
    }
}
