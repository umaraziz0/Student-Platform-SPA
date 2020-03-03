<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('student_id');
            $table->foreign('student_id')->references('student_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('course_name');
            $table->foreign('course_name')->references('course_name')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date');
            $table->time('time', 0);
            $table->string('room')->nullable();
            $table->string('building')->nullable();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('exams');
    }
}
