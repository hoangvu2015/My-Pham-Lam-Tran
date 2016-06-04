<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('approver_id')->unsigned()->nullable();
            $table->string('languages')->nullable();
            $table->string('available_times')->nullable();
            $table->decimal('paid_per_hour')->nullable()->default(2);
            $table->string('certificates')->nullable();
            $table->text('about_me')->nullable();
            $table->string('short_description')->nullable();
            $table->longText('methodology')->nullable();
            $table->string('youtube')->nullable()->default('https://www.youtube.com/watch?v=PRmmYDBauEU');
            $table->integer('rank')->unsigned()->default(0);
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('teachers');
    }
}
