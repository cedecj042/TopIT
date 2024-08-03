<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
    
        $student = Student::create([
            'firstname' => 'Kyo',
            'lastname' => 'Sohma',
            'theta_score'=>0.0,
            'birthdate' => '2002-10-12',
            'age' => '21',
            'gender' => 'Male',
            'address' => 'Address 123',
            'school' => 'Cebu Institute of Technology University',
            'school_year' => '3',
            'profile_image' => 'pochacco.jpg',
        ]);

        User::create([
            'username' => 'kyo123',
            'email' => 'kyo@gmail.com',
            'password' => Hash::make('usjr1234'), 
            'userable_id' => $student->student_id,
            'userable_type' => Student::class,
        ]);

        $student = Student::create([
            'firstname' => 'Yuki',
            'lastname' => 'Sohma',
            'theta_score'=>0.0,
            'birthdate' => '2005-11-12',
            'age' => '21',
            'gender' => 'Male',
            'address' => 'Another Address 123',
            'school' => 'University of San Jose Recoletos',
            'school_year' => '2',
            'profile_image' => 'pochacco.jpg',
        ]);

        User::create([
            'username' => 'yuki123',
            'email' => 'yuki@gmail.com',
            'password' => Hash::make('usjr1234'), 
            'userable_id' => $student->student_id,
            'userable_type' => Student::class,
        ]);

        $student = Student::create([
            'firstname' => 'Tohru',
            'lastname' => 'Honda',
            'theta_score'=>0.0,
            'birthdate' => '2004-05-20',
            'age' => '21',
            'gender' => 'Female',
            'address' => 'Village This 123',
            'school' => 'Cebu Institute of Technology University',
            'school_year' => '2',
            'profile_image' => 'pochacco.jpg',
        ]);

        User::create([
            'username' => 'tohru123',
            'email' => 'tohru@gmail.com',
            'password' => Hash::make('usjr1234'), 
            'userable_id' => $student->student_id,
            'userable_type' => Student::class,
        ]);

        $student = Student::create([
            'firstname' => 'Namjoon',
            'lastname' => 'Kim',
            'theta_score'=>0.0,
            'birthdate' => '1998-10-12',
            'age' => '26',
            'gender' => 'Male',
            'address' => 'Seoul, South Korea',
            'school' => 'University of San Jose Recoletos',
            'school_year' => '5',
            'profile_image' => 'pochacco.jpg',
        ]);

        User::create([
            'username' => 'knj123',
            'email' => 'knj@gmail.com',
            'password' => Hash::make('usjr1234'), 
            'userable_id' => $student->student_id,
            'userable_type' => Student::class,
        ]);

        $student = Student::create([
            'firstname' => 'Stephanie',
            'lastname' => 'Gomez',
            'theta_score'=>0.0,
            'birthdate' => '2002-10-12',
            'age' => '21',
            'gender' => 'Female',
            'address' => 'Address 123',
            'school' => 'Cebu Institute of Technology University',
            'school_year' => '4',
            'profile_image' => 'pochacco.jpg',
        ]);

        User::create([
            'username' => 'stephanie123',
            'email' => 'steph@gmail.com',
            'password' => Hash::make('usjr1234'), 
            'userable_id' => $student->student_id,
            'userable_type' => Student::class,
        ]);

        $student = Student::create([
            'firstname' => 'Taehyung',
            'lastname' => 'Kim',
            'theta_score'=>0.0,
            'birthdate' => '1999-10-12',
            'age' => '23',
            'gender' => 'Male',
            'address' => 'Address 123',
            'school' => 'University of San Carlos',
            'school_year' => '4',
            'profile_image' => 'pochacco.jpg',
        ]);

        User::create([
            'username' => 'kth123',
            'email' => 'kth@gmail.com',
            'password' => Hash::make('usjr1234'), 
            'userable_id' => $student->student_id,
            'userable_type' => Student::class,
        ]);
    }
}
