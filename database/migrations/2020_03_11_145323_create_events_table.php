<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('student_id');
            $table->foreign('student_id')->references('student_id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->datetime('start', 0);
            $table->datetime('end', 0)->nullable();
            $table->boolean('all_day')->default(false);
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
        Schema::dropIfExists('events');
    }
}
