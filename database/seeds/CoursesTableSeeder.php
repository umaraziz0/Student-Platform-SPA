<?php

use App\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
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
                'course_id' => 1,
                'course_name' => 'Algorithms',
                'credits' => 4
            ),
            array(
                'course_id' => 1,
                'course_name' => 'Data Structures',
                'credits' => 4
            ),
            array(
                'course_id' => 3,
                'course_name' => 'Intro to Computer Science',
                'credits' => 4
            ),
            array(
                'course_id' => 4,
                'course_name' => 'Computer Networks',
                'credits' => 3
            ),
            array(
                'course_id' => 5,
                'course_name' => 'Security Principles',
                'credits' => 3
            )
        );

        Course::insert($courses);
    }
}
