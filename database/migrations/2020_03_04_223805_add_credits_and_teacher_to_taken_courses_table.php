<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditsAndTeacherToTakenCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taken_courses', function (Blueprint $table) {
            $table->integer('credits')->nullable();
            $table->string('teacher')->nullable();
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
            $table->dropColumn('credits');
            $table->dropColumn('teacher');
        });
    }
}
