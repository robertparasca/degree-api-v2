<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'parascarobert@gmail.com',
            'password' => Hash::make('asd123'),
            'is_student' => true,
            'is_account_active' => true,
        ]);
        DB::table('users')->insert([
            'email' => 'caprianovidiu@gmail.com',
            'password' => Hash::make('asd123'),
            'is_student' => true,
            'is_account_active' => true,
        ]);
        DB::table('users')->insert([
            'email' => 'staff@gmail.com',
            'password' => Hash::make('asd123'),
            'is_account_active' => true,
        ]);



        DB::table('students')->insert([
            'first_name' => 'Robert',
            'last_name' => 'Parasca',
            'full_name' => 'Parasca Robert',
            'birth_name' => 'Parasca',
            'father_name_initial' => 'C',
            'unique_registration_number' => 7275,
            'group' => '1403A',
            'active_year' => 'IV',
            'field_of_study' => 'Ingineria Sistemelor',
            'program_of_study' => 'Informatica Aplicata',
            'admission_grade' => 7.29,
            'admission_year' => '2016',
            'start_year' => '2016',
            'is_paying_tax' => false,
            'is_second_university' => false,
            'user_id' => 1
        ]);
        DB::table('students')->insert([
            'first_name' => 'Ovidiu',
            'last_name' => 'Caprian',
            'full_name' => 'Caprian Ovidiu',
            'birth_name' => 'Caprian',
            'father_name_initial' => 'C',
            'unique_registration_number' => 7274,
            'group' => '1403A',
            'active_year' => 'IV',
            'field_of_study' => 'Ingineria Sistemelor',
            'program_of_study' => 'Informatica Aplicata',
            'admission_grade' => 7.29,
            'admission_year' => '2016',
            'start_year' => '2016',
            'is_paying_tax' => false,
            'is_second_university' => false,
            'user_id' => 2
        ]);


        DB::table('staff')->insert([
            'first_name' => 'Staff',
            'last_name' => 'Staff',
            'user_id' => 3
        ]);



        DB::table('tickets')->insert([
            'user_id' => 1,
            'reason' => 'Pentru locul de munca',
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('tickets')->insert([
            'user_id' => 2,
            'reason' => 'Pentru medicul de familie',
            'created_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('scholarships')->insert([
            'amount' => 100,
            'unique_registration_number' => 7275,
            'type' => 'merit'
        ]);



        DB::table('institutes')->insert([
//            'university_name' => 'Universitatea Tehnică "Gheorghe Asachi" Iași',
//            'faculty_name' => 'Facultatea de Automatică și Calculatoare',
            'dean_name' => 'Popescu Dan',
            'secretary_name' => 'Popescu Ioan',
            'start_date' => new Carbon('2019-09-26'),
            'mid_date' => new Carbon('2020-02-16'),
            'end_date' => new Carbon('2020-07-31'),
        ]);



        // $this->call(UserSeeder::class);
    }
}
