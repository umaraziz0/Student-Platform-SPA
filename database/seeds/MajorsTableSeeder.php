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
                'major_id' => 1,
                'name' => 'Computer Science'
            ),
            array(
                'major_id' => 2,
                'name' => 'Software Engineering'
            ),
            array(
                'major_id' => 3,
                'name' => 'International Trade and Economics'
            ),
            array(
                'major_id' => 4,
                'name' => 'International Law'
            ),
            array(
                'major_id' => 5,
                'name' => 'Computer Engineering'
            ),
        );

        Major::insert($courses);
    }
}
