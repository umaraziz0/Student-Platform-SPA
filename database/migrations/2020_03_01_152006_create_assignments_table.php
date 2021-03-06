<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('student_id');
            $table->string('name');
            $table->integer('course_id');
            $table->date('due_date')->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
            $table->foreign('student_id')->references('student_id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('course_id')->references('course_id')->on('courses')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
