<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTeachers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->text('target_help')->default('');
            $table->text('target_students')->default('');
            $table->text('target_student_achievements')->default('');
            $table->text('experience')->default('');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('voice')->default('');
            $table->text('interests')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
