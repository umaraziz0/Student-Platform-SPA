<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTakenCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taken_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('student_id')->unique();
            $table->foreign('student_id')->references('student_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('course_name');
            $table->foreign('course_name')->references('course_name')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taken_courses');
    }
}
