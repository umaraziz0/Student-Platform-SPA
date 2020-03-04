<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsIntoCoursesTakenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taken_courses', function (Blueprint $table) {
            $table->integer('student_id');
            $table->string('course_name');
            $table->integer('course_id');
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
            $table->dropColumn('student_id');
            $table->dropColumn('course_id');
            $table->dropColumn('course_name');
        });
    }
}
