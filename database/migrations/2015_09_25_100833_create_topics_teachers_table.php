<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics_teachers', function (Blueprint $table) {
            $table->integer('topic_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();

            $table->primary(['topic_id', 'teacher_id']);
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topics_teachers');
    }
}
