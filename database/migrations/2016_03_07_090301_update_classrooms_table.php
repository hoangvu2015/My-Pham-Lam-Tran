<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('classrooms');
        Schema::dropIfExists('classrooms_users');
        Schema::create('classrooms_users', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('classroom_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
        });
        Schema::create('classrooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string("classname");
            $table->integer('hours_estimate')->unsigned();
            $table->integer('hours_real')->unsigned();
            $table->text("note")->nullable();
            $table->text("url_detail")->nullable();
            $table->enum('status', ['unpublished', 'trial','published','closed']);

            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('closed_by')->unsigned();

//            $table->foreign('created_by')->references('id')->on('users');
//            $table->foreign('closed_by')->references('id')->on('users');
            $table->dateTime('closed_date');

            $table->timestamps();
        });

        Schema::table('classrooms_users', function (Blueprint $table) {
            $table->foreign('classroom_id')->references('id')->on('classrooms');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classrooms', function (Blueprint $table) {
            //
        });
    }
}
