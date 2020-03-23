<?php

use App\Major;
use Illuminate\Database\Seeder;

class MajorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = array(
            array(
                'name' => 'Computer Science'
            ),
            array(
                'name' => 'Software Engineering'
            ),
            array(
                'name' => 'International Trade and Economics'
            ),
            array(
                'name' => 'International Law'
            ),
            array(
                'name' => 'Computer Engineering'
            ),
        );

        Major::insert($courses);
    }
}
