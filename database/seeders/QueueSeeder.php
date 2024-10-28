<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('queues')->insert([
            [
                'user_id' => 7, 
                'creator_id' => 1, 
                'title' => 'Consultation',
                'fname' => 'Keisuke',
                'lname' => 'Karishuku',
                'contact' => '09123456789',
                'email' => '202011578@gordoncollege.edu.ph',
                'start' => Carbon::now()->addDays(1), // Start time tomorrow
                'end' => Carbon::now()->addDays(1)->addHours(1), // End time one hour after start
                'status' => 'pending',
                'otherText' => null,
                'position' => 1,
                'problem' => 'Need help with coursework.',
                'resolve' => null,
                'remarks' => null,
                'note' => 'Prepare questions beforehand.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7, 
                'creator_id' => 2, 
                'title' => 'Consultation',
                'fname' => 'Vanjoe',
                'lname' => 'Santos',
                'contact' => '09123456789',
                'email' => '202011579@gordoncollege.edu.ph',
                'start' => Carbon::now()->addDays(2), // Start time two days from now
                'end' => Carbon::now()->addDays(2)->addHours(1), // End time one hour after start
                'status' => 'approved',
                'otherText' => null,
                'position' => 2,
                'problem' => 'Discuss project topics.',
                'resolve' => null,
                'remarks' => null,
                'note' => 'Bring project outlines.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7, 
                'creator_id' => 3, 
                'title' => 'Consultation',
                'fname' => 'Noel',
                'lname' => 'Ervas',
                'contact' => '09123456789',
                'email' => '202011580@gordoncollege.edu.ph',
                'start' => Carbon::now()->addDays(3), // Start time three days from now
                'end' => Carbon::now()->addDays(3)->addHours(1), // End time one hour after start
                'status' => 'pending',
                'otherText' => null,
                'position' => 3,
                'problem' => 'Seek advice on thesis.',
                'resolve' => null,
                'remarks' => null,
                'note' => 'Gather research materials.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7, 
                'creator_id' => 4, 
                'title' => 'Consultation',
                'fname' => 'Troy',
                'lname' => 'Reandino',
                'contact' => '09123456789',
                'email' => '202011581@gordoncollege.edu.ph',
                'start' => Carbon::now()->addDays(4), // Start time four days from now
                'end' => Carbon::now()->addDays(4)->addHours(1),
                'status' => 'done',
                'otherText' => null,
                'position' => 4,
                'problem' => 'Discuss internship opportunities.',
                'resolve' => null,
                'remarks' => null,
                'note' => 'Prepare resume and cover letter.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7, 
                'creator_id' => 5, 
                'title' => 'Consultation',
                'fname' => 'Michael',
                'lname' => 'Baran',
                'contact' => '09123456789',
                'email' => '202011582@gordoncollege.edu.ph',
                'start' => Carbon::now()->addDays(5), // Start time five days from now
                'end' => Carbon::now()->addDays(5)->addHours(1),
                'status' => 'pending',
                'otherText' => null,
                'position' => 5,
                'problem' => 'Receive feedback on recent project.',
                'resolve' => null,
                'remarks' => null,
                'note' => 'Bring project report.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7, 
                'creator_id' => 6, 
                'title' => 'Consultation',
                'fname' => 'Lee Ryan',
                'lname' => 'Garcia',
                'contact' => '09123456789',
                'email' => '202011583@gordoncollege.edu.ph',
                'start' => Carbon::now()->addDays(6), // Start time six days from now
                'end' => Carbon::now()->addDays(6)->addHours(1),
                'status' => 'approved',
                'otherText' => null,
                'position' => 6,
                'problem' => 'Clarify lecture topics.',
                'resolve' => null,
                'remarks' => null,
                'note' => 'Bring lecture notes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7, 
                'creator_id' => 1, 
                'title' => 'Consultation',
                'fname' => 'Keisuke',
                'lname' => 'Karishuku',
                'contact' => '09123456789',
                'email' => '202011578@gordoncollege.edu.ph',
                'start' => Carbon::create(2024, 10, 19, 10, 0, 0), 
                'end' => Carbon::create(2024, 10, 19, 11, 0, 0),
                'status' => 'lapse',
                'otherText' => null,
                'position' => 7,
                'problem' => 'Follow up on submitted paper.',
                'resolve' => null,
                'remarks' => null,
                'note' => 'Check submission status.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
