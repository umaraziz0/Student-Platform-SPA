<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseidToCoursestakenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taken_courses', function (Blueprint $table) {
            $table->integer('course_id')->unique();
            $table->foreign('course_id')->references('course_id')->on('courses')
                ->onDelete('cascade')->onUpdate('cascade');
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
            $table->dropColumn('course_id');
        });
    }
}
