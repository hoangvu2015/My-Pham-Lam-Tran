<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmpLearningRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_learning_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('student_id')->unsigned()->nullable();
            $table->bigInteger('teacher_id')->unsigned()->nullable();
            $table->char('locale', 2)->index();
            $table->string('name');
            $table->string('email')->index();
            $table->string('phone')->index();
            $table->string('skype')->index();
            $table->text('course_expectation')->default('');
            $table->text('goal')->default('');
            $table->tinyInteger('count_schedules')->default(10);
            $table->text('duration')->default('');
            $table->text('charge')->default('');
            $table->text('schedule_expectation')->default('');
            $table->char('teacher_country', 2)->default('VN');
            $table->char('teacher_sex', 10)->default('male');
            $table->boolean('teacher_test_required', 10)->default(false);
            $table->text('extra_information', 10)->default('');
            $table->enum('status', ['newly', 'process'])->default('newly');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tmp_learning_requests');
    }
}
