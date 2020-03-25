<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaughtCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taught_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('course_id');
            $table->foreign('course_id')->references('course_id')->on('courses')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('teacher_id');
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers')
                ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('taught_courses');
    }
}
