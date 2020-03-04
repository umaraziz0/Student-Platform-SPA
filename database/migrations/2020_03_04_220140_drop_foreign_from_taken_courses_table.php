<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignFromTakenCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taken_courses', function (Blueprint $table) {
            $table->dropForeign('taken_courses_student_id_foreign');
            $table->dropForeign('taken_courses_course_id_foreign');
            $table->dropForeign('taken_courses_course_name_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taken_courses', function (Blueprint $table) {
            $table->foreign('student_id')->references('student_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('course_name')->references('course_name')->on('courses')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
