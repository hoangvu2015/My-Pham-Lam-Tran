<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            // $table->removeColumn('name');
            $table->string('title')->nullable();
            $table->string('des')->nullable();
            $table->string('slug');
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->datetime('date_close')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status_trial')->default(0);
            $table->double('salary_hour')->unsigned()->nullable();
            $table->tinyInteger('is_close')->default(0);
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('des')->nullable();
            $table->string('slug');
            $table->datetime('learn_date')->nullable();
            $table->float('duration')->unsigned()->default(0);
            $table->tinyInteger('status_trial')->default(0);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->text('recomment')->nullable();
        });

        Schema::create('courses_users_roles', function (Blueprint $table) {
            $table->integer('course_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->primary(['course_id', 'user_id', 'role_id']);
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->integer('lesson_id')->nullable();
            $table->integer('role_id')->nullable();
        });

        // Schema::create('lessons_reviews_users_roles', function (Blueprint $table) {
        //     $table->integer('lesson_id')->unsigned();
        //     $table->bigInteger('review_id')->unsigned();
        //     $table->bigInteger('user_id')->unsigned();
        //     $table->integer('role_id')->unsigned();

        //     $table->primary(['lesson_id', 'review_id','user_id', 'role_id'],'lesson_id_review_id_user_id_role_id');
        //     $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
        //     $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('courses_users_roles');
        // Schema::drop('lessons_reviews_users_roles');
    }
}
