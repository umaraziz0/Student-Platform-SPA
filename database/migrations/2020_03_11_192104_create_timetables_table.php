<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('student_id');
            $table->foreign('student_id')->references('student_id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('course_id');
            $table->foreign('course_id')->references('course_id')->on('courses')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('class_type')->default('lecture');
            $table->string('day');
            $table->time('start', 0);
            $table->time('end', 0);
            $table->string('room')->nullable();
            $table->string('building')->nullable();
            $table->text('details')->nullable();
            $table->string('color')->default('#3788d9');
            $table->string('text_color')->default('#ffffff');
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
        Schema::dropIfExists('timetables');
    }
}
