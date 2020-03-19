<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('teacher_id')->unique();
            $table->string('photo')->nullable();
            $table->string('name');
            $table->unsignedBigInteger('phone')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->text('office_address')->nullable();
            $table->string('office_hours')->nullable();
            $table->string('courses_taught')->nullable();
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
        Schema::dropIfExists('teachers');
    }
}
