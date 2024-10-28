<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'fname' => 'Keisuke',
                    'lname' => 'Karishuku',
                    'course_id' => 2,  
                    'year_id' => 4,  
                    'contact' => '09123456789',
                    'email' => '202011578@gordoncollege.edu.ph',
                    'role' => '0',
                    'password' => Hash::make('111312123'),
                ],
                [
                    'fname' => 'Vanjoe',
                    'lname' => 'Santos',
                    'course_id' => 2,  
                    'year_id' => 4,  
                    'contact' => '09123456789',
                    'email' => '202011579@gordoncollege.edu.ph',
                    'role' => '0',
                    'password' => Hash::make('111312123'),
                ],
                [
                    'fname' => 'Noel',
                    'lname' => 'Ervas',
                    'course_id' => '2',  
                    'year_id' => '4',  
                    'contact' => '09123456789',
                    'email' => '202011580@gordoncollege.edu.ph',
                    'role' => '0',
                    'password' => Hash::make('111312123'),
                ],
                [
                    'fname' => 'Troy',
                    'lname' => 'Reandino',
                    'course_id' => '2',  
                    'year_id' => '4',  
                    'contact' => '09123456789',
                    'email' => '202011581@gordoncollege.edu.ph',
                    'role' => '0',
                    'password' => Hash::make('111312123'),
                ],
                [
                    'fname' => 'Michael',
                    'lname' => 'Baran',
                    'course_id' => '2',  
                    'year_id' => '4',  
                    'contact' => '09123456789',
                    'email' => '202011582@gordoncollege.edu.ph',
                    'role' => '0',
                    'password' => Hash::make('111312123'),
                ],
                [
                    'fname' => 'Lee Ryan',
                    'lname' => 'Garcia',
                    'course_id' => '2',  
                    'year_id' => '4',  
                    'contact' => '09123456789',
                    'email' => '202011583@gordoncollege.edu.ph',
                    'role' => '0',
                    'password' => Hash::make('111312123'),
                ],
                [
                    'fname' => 'Loudel',
                    'lname' => 'Manaloto',
                    'course_id' => '2',  
                    'year_id' => '4',  
                    'contact' => '09123456789',
                    'email' => '202011571@gordoncollege.edu.ph',
                    'role' => '1',
                    'password' => Hash::make('111312123'),
                ],
                [
                    'fname' => 'Denise',
                    'lname' => 'Punzalan',
                    'course_id' => '2',  
                    'year_id' => '4',  
                    'contact' => '09123456789',
                    'email' => '202011572@gordoncollege.edu.ph',
                    'role' => '1',
                    'password' => Hash::make('111312123'),
                ],
                [
                    'fname' => 'Rey',
                    'lname' => 'Bautista',
                    'course_id' => '1',  
                    'year_id' => '4',  
                    'contact' => '09123456789',
                    'email' => '202011573@gordoncollege.edu.ph',
                    'role' => '3',
                    'password' => Hash::make('111312123'),
                ],
                [
                    'fname' => 'GC',
                    'lname' => 'Admin',
                    'course_id' => '2',  
                    'year_id' => '4',  
                    'contact' => '09123456789',
                    'email' => '202011111@gordoncollege.edu.ph',
                    'role' => '2',
                    'password' => Hash::make('111312123'),
                ],
            ]

        );
    }
}
