<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            array(
                'name' => 'admin',
                'student_id' => 0,
                'email' => 'admin@mail.com',
                'password' => Hash::make('devourer97'),
                'is_admin' => true
            ),
            array(
                'name' => 'student',
                'student_id' => 1,
                'email' => 'student@mail.com',
                'password' => Hash::make('devourer97'),
                'is_admin' => true
            )
        );

        User::insert($users);
    }
}
