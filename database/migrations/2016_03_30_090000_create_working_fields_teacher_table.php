<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingFieldsTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_fields_teachers', function (Blueprint $table) {
            $table->integer('fields_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();

            $table->primary(['fields_id', 'teacher_id']);
            $table->foreign('fields_id')->references('id')->on('working_fields')->onDelete('cascade');
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
        Schema::drop('working_fields_teachers');
    }
}
