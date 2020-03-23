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
                'password' => Hash::make('admin1234'),
                'is_admin' => true
            ),
            array(
                'name' => 'student',
                'student_id' => 1,
                'password' => Hash::make('student1234'),
                'is_admin' => false
            )
        );

        User::insert($users);
    }
}
