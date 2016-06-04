<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCoursesNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->integer('learning_hours');
            $table->dropColumn(['name', 'description']);
            $table->float('price');
            $table->tinyInteger('status')->default(0);

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('course_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description');
            $table->text('content');
            $table->string('locale')->index();

            $table->unique(['course_id', 'locale']);
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('course_translations');
    }
}
